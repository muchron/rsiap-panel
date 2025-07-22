<?php

namespace Database\Factories;

use App\Models\Polyclinic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $polyclinic = Polyclinic::inRandomOrder()->first();

        return [
            'user_id' => User::where('username', 'like', '1.%')->inRandomOrder()->first()?->id,
            'polyclinic_id' => $polyclinic->id,
            'day' => fake()->date('d'),
            'start_at' => fake()->time('H:i:s'),
            'end_at' => fake()->time('H:i:s'),
        ];
    }
}
