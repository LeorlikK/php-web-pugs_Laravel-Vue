<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Comment;
use App\Models\News;
use Database\Seeders\TestCommentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TestCommentSeeder::class);
    }

    public function test_comment()
    {
        $newsPublishTrue = News::query()->where('publish', true)->first();
        $response = $this->get("/api/comments/$newsPublishTrue->id/");

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertJsonFragment([
            'current_page' => 1
        ]);
        $data = json_decode($response->getContent(), true);
        $parent_comment = array_column($data['data'], 'parent_comment');
        $nullArray = [];
        for ($i = 0; $i < 10; $i++) {
            $nullArray[] = null;
        }
        $this->assertEquals($nullArray, $parent_comment);
    }

    public function test_page_comment()
    {
        $page = 2;
        $newsPublishTrue = News::query()->where('publish', true)->first();
        $response = $this->get("/api/comments/$newsPublishTrue->id/$page");

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertJsonFragment([
            'current_page' => $page
        ]);
        $data = json_decode($response->getContent(), true);
        $parent_comment = array_column($data['data'], 'parent_comment');
        $nullArray = [];
        for ($i = 0; $i < 10; $i++) {
            $nullArray[] = null;
        }
        $this->assertEquals($nullArray, $parent_comment);
    }

    public function test_parent_comment()
    {
        $page = 1;
        $parentComment = 1;
        $newsPublishTrue = News::query()->where('publish', true)->first();
        $response = $this->get("/api/comments/$newsPublishTrue->id/$page/$parentComment");

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        $response->assertJsonFragment([
            'current_page' => $page
        ]);
        $data = json_decode($response->getContent(), true);
        $parent_comment = array_column($data['data'], 'parent_comment');
        $parentCommentArray = [];
        for ($i = 0; $i < 10; $i++) {
            $parentCommentArray[] = $parentComment;
        }
        $this->assertEquals($parentCommentArray, $parent_comment);
    }
}
