<?php

namespace Database\Factories;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Articles>
 */
class ArticlesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'body' => fake()->paragraph(),
            'status' => fake()->randomElement(['draft', 'published']),
            'cover' => fake()->imageUrl(),
            'view' => fake()->numberBetween(0, 100),
            'user_id' => User::inRandomOrder()->first()?->id,
            'created_at' => fake()->dateTimeBetween('-5 month', 'now'),
            'category_id' => Categories::inRandomOrder()->first()?->id,
        ];
    }
}
