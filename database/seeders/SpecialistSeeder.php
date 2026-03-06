<?php

namespace Database\Seeders;

use App\Models\Specialist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SpecialistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('db2')->table('spesialis')
            ->where('kd_sps', '!=', '-')
            ->where('kd_sps', '!=', 'UMUM')
            ->get()
            ->each(function ($value) {
                Specialist::create(
                    [
                        'id' => $value->kd_sps,
                        'slug' => Str::slug($value->nm_sps),
                        'name' => $value->nm_sps,
                        'is_polyclinic' => true,

                    ]
                );
            });
    }
}
