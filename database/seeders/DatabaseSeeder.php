<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Labels;
use App\Models\Articles;
use App\Models\Schedule;
use App\Models\ApiService;
use App\Models\Categories;
use App\Models\Polyclinic;
use App\Models\ArticleLabels;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Categories::factory()->count(10)->create();
        Labels::factory()->count(10)->create();
        $this->user();

        Articles::factory()->count(10)->create()->each(function ($article) {
            $user = User::where('username', 'like', '1.%')->inRandomOrder()->first();
            $article->user()->associate($user);
            $article->save();
        });

        // Articles::factory()->count(10)
        //     ->hasAttached(User::where('username', 'like', '1.%')->inRandomOrder()->first())
        //     ->create();

        ArticleLabels::factory()->count(10)->create();
        ApiService::factory()->count(4)->create();
        $this->polyclinic();
        $this->schedule();

    }
    function user()
    {
        try {
            $source = DB::connection('db2')->table('pegawai')
                ->where('stts_aktif', 'AKTIF')
                ->get();


            foreach ($source as $source => $value) {
                User::create([
                    'name' => $value->nama,
                    'username' => $value->nik,
                    'phone' => fake()->numberBetween(1111111111, 999999999),
                    'password' => bcrypt('password'),
                    'remember_token' => fake()->uuid
                ]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    function schedule()
    {
        $sources = DB::connection('db2')->table('jadwal')
            ->where('kd_dokter', '!=', '1.101.1112')
            ->get();

        foreach ($sources as $source => $value) {
            $data = [
                'doctor_id' => $value->kd_dokter,
                'day' => $value->hari_kerja,
                'start_at' => $value->jam_mulai,
                'polyclinic_code' => $value->kd_poli,
                'end_at' => $value->jam_selesai,
            ];
            Schedule::create($data);
        }
    }
    function polyclinic()
    {
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
