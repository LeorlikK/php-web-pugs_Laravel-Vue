<?php

namespace Database\Seeders;

use App\Models\Audio;
use App\Models\Photo;
use App\Models\Video;
use Illuminate\Database\Seeder;

class TestMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Photo::factory(50)->create();
        Video::factory(50)->create();
        Audio::factory(50)->create();
    }
}
