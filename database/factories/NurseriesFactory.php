<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nurseries>
 */
class NurseriesFactory extends Factory
{
//    protected $model = 'Nurseries';
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name(),
            'text' => fake()->text(200),
            'address' => fake()->address(),
            'phone' => fake()->phoneNumber(),
            'image_url' => 'images/avatars/avatar_default.png',
        ];
    }
}
