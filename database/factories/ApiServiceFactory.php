<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ApiService>
 */
class ApiServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cons_id' => $this->faker->randomNumber(6, true),
            'api_key' => $this->faker->uuid(),
            'request_by' => \App\Models\User::all()->random()->username,
            'created_by' => \App\Models\User::all()->random()->username,
            'project' => $this->faker->randomElement(['Project A', 'Project B', 'Project C']),
        ];
    }
}
