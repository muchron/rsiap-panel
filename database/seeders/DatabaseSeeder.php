<?php

namespace Database\Seeders;

use App\Models\ArticleLabels;
use App\Models\Articles;
use App\Models\Categories;
use App\Models\Labels;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Categories::factory()->count(10)->create();
        Labels::factory()->count(10)->create();
        User::factory()
            ->has(Articles::factory()->count(3))
            ->count(10)
            ->create();
        // Articles::factory()->count(10)->create();
        ArticleLabels::factory()->count(10)->create();



        // User::factory()->create([
        //     'name' => 'Test User',
        //     'username' => 'test@example.com',
        // ]);
    }
}
