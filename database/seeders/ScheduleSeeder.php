<?php

namespace Database\Seeders;

use App\Models\Polyclinic;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sources = DB::connection('db2')->table('jadwal')
            ->where('kd_dokter', '!=', '1.101.1112') // Exclude specific doctor if needed
            ->get();

        foreach ($sources as $value) {
            // Find the corresponding User (doctor) by their 'username' (which holds 'kd_dokter'/'nik')
            $doctor = User::where('username', $value->kd_dokter)->first();

            // Find the corresponding Polyclinic by its 'code'
            $polyclinic = Polyclinic::where('code', $value->kd_poli)->first();

            // Only create the schedule if both the doctor and polyclinic exist in your main database
            if ($doctor && $polyclinic) {
                $data = [
                    'doctor_id' => $doctor->username, // Use the actual ID from the 'users' table
                    'day' => $value->hari_kerja,
                    'start_at' => $value->jam_mulai,
                    'polyclinic_id' => $value->kd_poli, // Use the actual ID from the 'polyclinics' table
                    'end_at' => $value->jam_selesai,
                ];
                Schedule::create($data);
            } else {
                // Provide specific warnings if either a doctor or polyclinic is not found
                if (! $doctor) {
                    echo "Warning: Doctor with username (kd_dokter) '{$value->kd_dokter}' not found in 'users' table. Skipping schedule entry.\n";
                }
                if (! $polyclinic) {
                    echo "Warning: Polyclinic with code (kd_poli) '{$value->kd_poli}' not found in 'polyclinics' table. Skipping schedule entry.\n";
                }
            }
        }
    }
}
