<?php

namespace Database\Seeders;

use App\Models\Polyclinic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PolyclinicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Polyclinic::truncate();
        $source = DB::connection('db2')->table('poliklinik')
            ->where('kd_poli', '!=', '-')
            ->get();
        foreach ($source as $key => $value) {
            $data = [
                'code' => $value->kd_poli,
                'name' => $value->nm_poli
            ];
            Polyclinic::create($data);
        }

    }
}
