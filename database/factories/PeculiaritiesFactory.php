<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peculiarities>
 */
class PeculiaritiesFactory extends Factory
{
    protected $model = 'Peculiarities';

    private static int $countId = 0;
    private static array $title = [
        'Особенности породы',
        'Уход и содержание',
        'Питание',
        'Здоровье',
        'Выгул',
    ];
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        self::$countId++;

        return [
            'title' => self::$title[self::$countId-1],
            'text' => null
        ];
    }
}
