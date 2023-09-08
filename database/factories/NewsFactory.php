<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake(),
            'image_url' => '/images/avatars/avatar_default.png',
            'title' => fake()->title(),
            'short' => fake()->text(50),
            'text' => fake()->text(200),
            'publish' => fake()->boolean(),
        ];
    }
}
