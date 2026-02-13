<?php

namespace Database\Seeders;

use App\Models\Carousel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            Carousel::create([
                'title' => 'Carousel ' . $i,
                'image' => 'carousel/' . $i . '.jpg',
                'is_active' => 1
            ]);
        }
    }
}
