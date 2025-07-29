<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('db2')->table('dokter')
            ->where('kd_sps', '!=', '-')
            ->get()
            ->each(function ($value) {
                Doctor::create([
                    'doctor_id' => $value->kd_dokter,
                    'slug' => Str::slug($value->nm_dokter),
                    'specialist_id' => $value->kd_sps,
                    'photo' => fake()->imageUrl(),
                    'about' => fake()->sentences(50, true)
                ]);
            });
    }
}
