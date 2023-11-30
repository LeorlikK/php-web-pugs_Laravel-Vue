<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Comment;
use App\Models\News;
use App\Models\Peculiarities;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory(1)->create();
        $news = News::factory(50)->create(['user_id' => $user->first()->id])->filter(function ($item){
            return $item->publish;
        });
        $comments = Comment::factory(50)->create([
            'news_id' => $news->first()->id,
            'user_id' => $user->first()->id,
        ]);
        Peculiarities::factory(5)->create();
    }
}
