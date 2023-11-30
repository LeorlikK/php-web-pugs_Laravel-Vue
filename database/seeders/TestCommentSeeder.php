<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory(1)->create();
        $news = News::factory(50)->create(['user_id' => $user->first()->id])->filter(function ($item){
            return $item->publish;
        });
        $comments = Comment::factory(25)->create([
            'news_id' => $news->first()->id,
            'user_id' => $user->first()->id,
        ]);
        $commentsWithParents = Comment::factory(25)->create([
            'news_id' => $news->first()->id,
            'user_id' => $user->first()->id,
            'parent_comment' => $comments->first()->id
        ]);
    }
}
