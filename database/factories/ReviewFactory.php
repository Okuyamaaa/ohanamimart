<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->realText(250),
            'score' => fake()->numberBetween(1, 5),
            'send_user_id' => fake()->randomNumber(),
            'user_id' => fake()->randomNumber(),
        ];
    }
}
