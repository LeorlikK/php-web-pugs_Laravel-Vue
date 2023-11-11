<?php

namespace App\Http\Controllers\Media;

use App\Http\Controllers\Controller;
use App\Http\Resources\Media\VideoResource;
use App\Models\Video;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
}
