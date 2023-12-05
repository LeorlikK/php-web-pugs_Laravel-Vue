<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\NewsStoreRequest;
use App\Http\Requests\News\NewsUpdateRequest;
use App\Http\Resources\News\NewsIndexResource;
use App\Http\Resources\News\NewsShowResource;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(News::class, 'news');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = 5;
        $page = (int) $request->input('page') ?? 1;

        $key = $page;
        $news = Cache::tags('news')->remember($key, now()->addMinutes(120), function () use($perPage, $page) {
            return News::with('user:id,login')
                ->where('publish', true)
                ->orderByDesc('created_at')
                ->paginate($perPage, '*', 'page', $page);
        });

        return NewsIndexResource::collection($news);
    }

    public function adminIndex(Request $request): AnonymousResourceCollection
    {
        $perPage = 10;
        $page = (int) $request->input('page') ?? 1;

        $news = News::withTrashed()->with('user:id,login')
            ->orderByDesc('created_at')
            ->paginate($perPage, '*', 'page', $page);

        return NewsIndexResource::collection($news);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewsStoreRequest $request):NewsShowResource
    {
        $request = $request->validated();

        if (isset($request['image'])) {
            $request['image_url'] = Storage::disk('public')->put(config('media.images.news'), $request['image']);

        } else {
            $request['image_url'] = config('media.default.news');
        }
        unset($request['image']);
        $request['publish'] = $request['publish'] === 'true';
        $request['user_id'] = auth()->user()->id;

        $news = News::create($request);
        Cache::tags('news')->flush();

        return NewsShowResource::make($news);
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news): NewsShowResource|JsonResponse
    {
//        $this->authorize('view', $news);
        $news->load('user');
        if (auth()?->user()?->role !== 'admin' && !$news->publish) {
            return response()->json(['error' => 'Статья не опубликована'], 404);
        }

        return NewsShowResource::make($news);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(News $news): NewsShowResource|JsonResponse
    {
        return NewsShowResource::make($news);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NewsUpdateRequest $request, News $news): NewsShowResource
    {
        $request = $request->validated();

        if (empty($request['image']) && !$news->image_url) {
            $request['image_url'] = config('media.default.news');
        } elseif (isset($request['image'])) {
            Storage::disk('public')->delete($news->image_url);
            $request['image_url'] = Storage::disk('public')->put(config('media.default.news'), $request['image']);
        }

        unset($request['image']);
        $request['publish'] = $request['publish'] === 'true';

        $news->update($request);
        $news->refresh();
        Cache::tags('news')->flush();

        return NewsShowResource::make($news);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(News $news): JsonResponse
    {
        if ($news->trashed()) {
            if ($news->image_url !== config('media.images.news')) {
                Storage::disk('public')->delete($news->image_url);
            }
            $news->forceDelete();
        }

        $news->comments()->delete();
        $news->delete();

        return response()->json(['success' => true], 204);
    }

    public function restore(News $news): NewsShowResource
    {
        $news->restore();

        return NewsShowResource::make($news);
    }

    public function publish(News $news): JsonResponse
    {
        $news->publish = !$news->publish;
        $news->save();
        $news->refresh();

        return response()->json(['lala' => $news->id, 'stat' => $news->publish]);
    }
}
