<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\News;
use Database\Seeders\TestNewsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NewsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TestNewsSeeder::class);
    }

    /**
     * A basic test example.
     */
    public function test_paginate(): void
    {
        $response = $this->get('/api/news');

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertJsonFragment([
            'current_page' => 1
        ]);

        $response = $this->get('/api/news/2');

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertJsonFragment([
            'current_page' => 2
        ]);
    }

    public function test_show(): void
    {
        $response = $this->get('/api/news/show/1');

        $response->assertStatus(200);
    }

    public function test_show_publish(): void
    {
        $newsPublishTrue = News::query()->where('publish', true)->first();
        $newsPublishFalse = News::query()->where('publish', false)->first();

        if ($newsPublishTrue && $newsPublishFalse) {
            $response = $this->get('/api/news/show/' . $newsPublishTrue->id);
            $response->assertStatus(200);

            $response = $this->get('/api/news/show/' . $newsPublishFalse->id);
            $response->assertStatus(404);
        }
    }

    public function test_show_with_comments()
    {
        $newsPublishTrue = News::query()->where('publish', true)->first();

        if ($newsPublishTrue) {
            $response = $this->get('/api/news/show/' . $newsPublishTrue->id);
            $response->assertStatus(200);
            $response->assertJsonIsObject();
            $data = json_decode($response->getContent());
            $this->assertIsArray($data->comments);
            $this->assertCount(50, $data->comments);
        }
    }
}
