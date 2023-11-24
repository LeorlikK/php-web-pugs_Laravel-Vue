<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\Photo\PhotoStoreRequest;
use App\Http\Requests\Media\Photo\PhotoUpdateRequest;
use App\Http\Resources\Media\PhotoResource;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index(?string $page=null): AnonymousResourceCollection
    {
        $perPage = 12;
        $page = (int) $page ?? 1;

        $photos = Photo::query()
            ->orderByDesc('created_at')
            ->paginate($perPage, '*', 'page', $page);

        return PhotoResource::collection($photos);
    }

    public function store(PhotoStoreRequest $request): PhotoResource
    {
        $request = $request->validated();

        $file = $request['image'];
        $size = $file->getSize();
        $url = Storage::disk('public')->put(config('media.images.photos'), $file);
        $name = $request['name'] ?? explode('.', $file->getClientOriginalName())[0];

        $photo = Photo::create([
            'name' => $name,
            'url' => $url,
            'size' => $size
        ]);

        return PhotoResource::make($photo);
    }

    public function edit(Photo $photo): PhotoResource
    {
        return PhotoResource::make($photo);
    }

    public function update(PhotoUpdateRequest $request, Photo $photo): PhotoResource
    {
        $request = $request->validated();

        if (isset($request['image'])) {
            if ($photo->url !== config('media.default.photo')) {
                Storage::disk('public')->delete($photo->url);
            }
            $request['url'] = Storage::disk('public')->put(config('media.images.photos'), $request['image']);
            unset($request['image']);
        }

        $photo->update($request);
        $photo->refresh();

        return PhotoResource::make($photo);
    }

    public function destroy(Photo $photo): JsonResponse
    {
        if ($photo->url !== config('media.images.photos')) {
                Storage::disk('public')->delete($photo->url);
        }

        $photo->delete();

        return response()->json(['success' => true], 204);
    }
}
