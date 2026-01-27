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
use App\Models\Specialist;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */

    public static ?string $password;
    public function run(): void
    {
        // Categories::factory()->count(10)->create();
        // Labels::factory()->count(10)->create();
        $this->user();

        // Articles::factory()->count(50)->create()->each(function ($article) {
        //     $user = User::where('username', 'like', '1.%')->inRandomOrder()->first();
        //     $article->user()->associate($user);
        //     $article->save();
        // });

        // ArticleLabels::factory()->count(10)->create();
        ApiService::factory()->count(4)->create();
        $this->polyclinic();
        $this->schedule();
        $specialistSeeder = new SpecialistSeeder();
        $specialistSeeder->run();
        $doctorSeeder = new DoctorSeeder();
        $doctorSeeder->run();
    }
    function user()
    {
        try {
            $sources = DB::connection('db2')->table('pegawai')
                ->whereNot('nik', 'admin')
                ->where('stts_aktif', 'AKTIF')
                ->get();

            DB::transaction(function () use ($sources) {
                User::updateOrCreate([
                    'name' => 'Administrator',
                    'username' => 'admin',
                    'phone' => fake()->numberBetween(1111111111, 999999999),
                    'password' => static::$password ??= Hash::make('passwordadmin'),
                    'remember_token' => Str::random(10),
                ]);

                foreach ($sources as $source => $value) {
                    User::create([
                        'name' => $value->nama,
                        'username' => $value->nik,
                        'phone' => fake()->numberBetween(1111111111, 999999999),
                        'password' => static::$password ??= Hash::make('password'),
                        'remember_token' => Str::random(10),
                    ]);
                }
            });
            $this->command->info('Seeding user dari db2 berhasil!');
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    function schedule()
    {
        $sources = DB::connection('db2')->table('jadwal')
            ->get();

        foreach ($sources as $source => $value) {
            $dokter = User::where('username', $value->kd_dokter)->first();
            $data = [
                'doctor_id' => $value->kd_dokter,
                'slug' => Str::slug($dokter->name),
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
                'slug' => Str::slug($value->nm_poli),
                'name' => $value->nm_poli
            ];
            Polyclinic::create($data);
        }
    }




}
