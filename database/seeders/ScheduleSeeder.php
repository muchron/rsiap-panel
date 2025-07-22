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
        $sources = DB::connection('db2')->table('jadwal')->get();

        foreach ($sources as $source => $value) {
            $data = [
                'doctor_id' => User::where('username', 'like', '1.%')->inRandomOrder()->first()?->username,
                'day' => $value->hari_kerja,
                'start_at' => $value->jam_mulai,
                'polyclinic_id' => Polyclinic::inRandomOrder()->first()->id,
                'end_at' => $value->jam_selesai,
            ];
            Schedule::create($data);
        }
    }
}
