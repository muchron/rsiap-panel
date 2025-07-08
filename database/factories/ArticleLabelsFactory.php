<?php

namespace Database\Factories;

use App\Models\Articles;
use App\Models\Labels;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ArticleLabels>
 */
class ArticleLabelsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'articles_id' => Articles::inRandomOrder()->first()?->id,
            'label_id' => Labels::inRandomOrder()->first()?->id,
        ];
    }
}
