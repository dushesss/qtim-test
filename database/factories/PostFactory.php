<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Класс-фабрика для генерации данных-заглушек
 *
 * Class PostFactory
 *
 * @package Database\Factories
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'detail' => $this->faker->paragraph($this->faker->numberBetween(10, 20)),
        ];
    }
}
