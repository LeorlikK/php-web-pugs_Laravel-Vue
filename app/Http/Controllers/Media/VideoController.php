<?php

namespace App\Http\Controllers\Media;

use App\Events\LoadingVideoEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Media\Video\VideoStoreRequest;
use App\Http\Requests\Media\Video\VideoUpdateRequest;
use App\Http\Resources\Media\VideoResource;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Exporters\EncodingException;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoController extends Controller
{
    public function index(?string $page=null): AnonymousResourceCollection
    {
        $perPage = 12;
        $page = (int) $page ?? 1;

        $photos = Video::query()
            ->orderByDesc('created_at')
            ->paginate($perPage, '*', 'page', $page);

        return VideoResource::collection($photos);
    }

    public function store(VideoStoreRequest $request): VideoResource|JsonResponse
    {
        $video = $request->file('video');
        $size = $video->getSize();
        $originalName = explode('.', $video->getClientOriginalName())[0];

        try {
            $media = FFMpeg::open($video);
            $durationInSeconds = intdiv($media->getDurationInSeconds(), 2);
            $frameVideoPath = config('media.images.video_frames') . '/' . hash('sha256', $originalName . now()->timestamp) . '.png';
            $frameVideo = $media->getFrameFromSeconds($durationInSeconds)
                ->export()
                ->toDisk('public')
                ->save($frameVideoPath);
        }catch (EncodingException $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], $exception->getCode());
        }

        $videoPath = Storage::disk('public')->put(config('media.videos.videos'), $video);

        if ($frameVideo && $videoPath) {
            $video = Video::create([
                'url' => $videoPath,
                'frame' => $frameVideoPath,
                'name' => $originalName,
                'size' => $size,
            ]);

            return VideoResource::make($video);
        }

        return response()->json(['success' => false]);
    }

    public function edit(Video $video): VideoResource
    {
        return VideoResource::make($video);
    }

    public function update(VideoUpdateRequest $request, Video $video): VideoResource
    {
        $request->validated();

        if ($request->input('image')) {

        }
        if ($request->input('video')) {

        }

        $video->update($request->all());
        $video->refresh();

        return VideoResource::make($video);
    }

    public function destroy(Video $video): JsonResponse
    {
        if ($video->url) {
            Storage::disk('public')->delete($video->url);
        }
        if ($video->frame) {
            Storage::disk('public')->delete($video->frame);
        }

        $video->delete();

        return response()->json(['success' => true], 204);
    }
}
