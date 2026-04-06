<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
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
            ->where('status', '1')
            ->where('kd_sps', '!=', '-')
            ->get()
            ->each(function ($value) {
                $user = User::where('username', $value->kd_dokter)->first();

                // Jika user ditemukan, baru buat data dokternya
                if ($user) {
                    Doctor::create([
                        'doctor_id' => $value->kd_dokter,
                        'slug' => Str::slug($user->name),
                        'specialist_id' => $value->kd_sps,
                        'photo' => fake()->imageUrl(),
                        'about' => fake()->sentences(3, true) // 50 kalimat mungkin terlalu panjang untuk seeder
                    ]);
                }
            });
    }
}
