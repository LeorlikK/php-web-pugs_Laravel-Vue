<?php

namespace App\Http\Controllers\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\CommentRequest;
use App\Http\Resources\CommentsResource;
use App\Models\Comment;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentsController extends Controller
{
    public function index(string $news, ?string $page=null, ?string $parent_comment=null): AnonymousResourceCollection
    {
        $perPage = 10;
        $page = (int) $page ?? 1;

        $comments = Comment::query()
            ->with('user')
            ->withCount('children')
            ->where('news_id', $news)
            ->when($parent_comment, function ($query) use($parent_comment) {
                $query->where('parent_comment', $parent_comment);
            }, function ($query) {
                $query->where('parent_comment', null);
            })
            ->orderByDesc('created_at')
            ->paginate($perPage, '*', 'page', $page);

        return CommentsResource::collection($comments);
    }

    public function store(CommentRequest $request): CommentsResource
    {
        $request->validated();
        $user = auth()->user();

        $comment = Comment::create([
            'news_id' => $request->input('news_id'),
            'user_id' => $user->id,
            'parent_comment' => $request->input('parent_comment'),
            'text' => $request->input('text'),
        ]);

        $comment->load('user');
        $comment->loadCount('children');

        return CommentsResource::make($comment);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        $comment->children->each(function ($children_comment) {
            $children_comment->delete();
        });
        $comment = $comment->delete();

        return response()->json(['success' => true], 204);
    }
}
