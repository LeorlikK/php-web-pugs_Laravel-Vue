<?php

namespace Tests\Feature\Media;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Database\Seeders\TestMediaSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Testing\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PhotoTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(TestMediaSeeder::class);
        Storage::fake('public');
    }
    /**
     * A basic test example.
     */
    public function test_store(): void
    {
        $fileTwo = File::image('name.jpg', 400, 400);
        $data = [
            'name' => 'PhotoOne',
            'file' => $fileTwo
        ];

        $response = $this->post('/api/media/photo/store', $data);

        $response->assertStatus(201);
        $this->assertDatabaseCount('photos', 1);
    }

    public function test_store_request(): void
    {
        $file = File::image('name.jpg', 50, 400);
        $data = [
            'file' => $file
        ];
        $response = $this->post('/api/media/photo/store', $data);
        $response->assertStatus(302);
        $this->assertDatabaseCount('photos', 0);
        $response->assertInvalid('file');

        $file = File::image('name.jpg', 50, 400)->size(15000);
        $data = [
            'name' => str_repeat('123456789', 50),
            'file' => $file
        ];
        $response = $this->post('/api/media/photo/store', $data);
        $response->assertStatus(302);
        $this->assertDatabaseCount('photos', 0);
        $response->assertInvalid(['file', 'name']);
    }

    public function test_update(): void
    {
        $fileTwo = File::image('name.jpg', 400, 400);
        $data = [
            'name' => 'PhotoOne',
            'file' => $fileTwo
        ];
        $response = $this->post('/api/media/photo/store', $data);
        $response->assertStatus(201);
        $this->assertDatabaseCount('photos', 1);

        $id = json_decode($response->getContent(), true)['id'];
        $newData = ['name' => 'NewFileName'];
        $response = $this->patch("/api/media/photo/update/$id", $newData);
        $newName = json_decode($response->getContent(), true)['name'];
        $this->assertEquals($newName, $newData['name']);
    }

    public function test_destroy(): void
    {
        $fileTwo = File::image('name.jpg', 400, 400);
        $data = [
            'name' => 'PhotoOne',
            'file' => $fileTwo
        ];
        $response = $this->post('/api/media/photo/store', $data);
        $response->assertStatus(201);
        $this->assertDatabaseCount('photos', 1);

        $id = json_decode($response->getContent(), true)['id'];
        $response = $this->delete("/api/media/photo/delete/$id");
        $response->assertStatus(204);
        $this->assertDatabaseCount('photos', 0);
    }
}
