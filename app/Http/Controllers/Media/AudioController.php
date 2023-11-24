<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\Audio\AudioStoreRequest;
use App\Http\Requests\Media\Photo\PhotoStoreRequest;
use App\Http\Requests\Media\Photo\PhotoUpdateRequest;
use App\Http\Resources\Media\AudioResource;
use App\Http\Resources\Media\PhotoResource;
use App\Models\Audio;
use App\Models\Photo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;

class AudioController extends Controller
{
    public function index(?string $page=null): AnonymousResourceCollection
    {
        $perPage = 12;
        $page = (int) $page ?? 1;

        $audio = Audio::query()
            ->orderByDesc('created_at')
            ->paginate($perPage, '*', 'page', $page);

        return AudioResource::collection($audio);
    }

    public function store(AudioStoreRequest $request): AudioResource
    {
        $request = $request->validated();

        $file = $request['audio'];
        $size = $file->getSize();
        $url = Storage::disk('public')->put(config('media.audios.audios'), $file);
        $name = $request['name'] ?? explode('.', $file->getClientOriginalName())[0];

        $photo = Audio::create([
            'name' => $name,
            'url' => $url,
            'size' => $size
        ]);

        return AudioResource::make($photo);
    }

    public function update(PhotoUpdateRequest $request, Photo $photo): AudioResource
    {
        $request = $request->validated();

        $photo->update(['name' => $request['name']]);
        $photo->refresh();

        return AudioResource::make($photo);
    }

    public function destroy(Audio $audio): JsonResponse
    {
        if ($audio->url !== config('media.default.audio')) {
            Storage::disk('public')->delete($audio->url);
        }

        $audio->delete();

        return response()->json(['success' => true], 204);
    }
}
