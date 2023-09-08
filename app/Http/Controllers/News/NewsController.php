<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(?string $page=null): AnonymousResourceCollection
    {
        $perPage = 10;
        $page = (int) $page ?? 1;

        $news = News::query()
            ->where('publish', true)
            ->orderByDesc('created_at')
            ->paginate($perPage, '*', 'page', $page);

        return NewsResource::collection($news);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(News $news): JsonResponse
    {
        if (!$news->publish) {
            return response()->json(['error' => 'Статья не опубликована'], 404);
        }
//        $news->load(['comments' => function($query){
//            $query->whereNull('parent_comment');
//        }]);

        return response()->json($news);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
