<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'login' => 'leorlik',
            'email' => 'leorlik@ya.ru',
            'role' => $this->faker->randomElement(['admin', 'user', 'moder']),
            'email_verified_at' => now(),
            'password' => Hash::make('Pristxolidc2013'),
            'avatar' => '/images/avatars/avatar_default.png',
            'banned' => false,
            'remember_token' => null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
