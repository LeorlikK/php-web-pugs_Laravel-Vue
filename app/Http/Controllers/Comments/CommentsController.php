<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\JsonResponse;

class CommentsController extends Controller
{
    public function index(string $news, ?string $page=null, ?string $parent_comment=null): JsonResponse
    {
        $perPage = 10;
        $page = (int) $page ?? 1;

        $comments = Comment::query()
            ->where('news_id', $news)
            ->when($parent_comment, function ($query) use($parent_comment) {
                $query->where('parent_comment', $parent_comment);
            })
            ->orderByDesc('created_at')
            ->paginate($perPage, '*', 'page', $page);

        return response()->json($comments);
    }
}
