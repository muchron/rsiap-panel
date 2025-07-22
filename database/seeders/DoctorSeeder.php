<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('db2')->table('dokter')
            ->where('status', '1')
            ->where('kd_sps', '!=', '-')
            ->get()
            ->each(function ($value) {
                Doctor::create([
                    'doctor_id' => $value->kd_dokter,
                    'specialist_id' => $value->kd_sps,
                    'photo' => fake()->imageUrl(),
                    'about' => fake()->sentences(50, true)
                ]);
            });
    }
}
