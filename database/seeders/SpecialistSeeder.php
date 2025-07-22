<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('db2')->table('spesialis')->where('kd_sps', '!=', '-')->get()
            ->each(function ($value) {
                Specialist::create([
                    'id' => $value->kd_sps,
                    'name' => $value->nm_sps
                ]
                );
            });
    }
}
