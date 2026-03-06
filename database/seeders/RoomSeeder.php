<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use function Livewire\str;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::connection('db2')->table('kamar')
            ->where('statusdata', '1')
            ->join('bangsal', 'kamar.kd_bangsal', '=', 'bangsal.kd_bangsal')
            ->get()
            ->each(function ($value) {

                Room::firstOrCreate(
                    ['name' => $value->nm_bangsal], // kondisi pengecekan
                    [
                        'category' => 'Umum',
                        'class' => strtolower(str_replace('Kelas ', '', $value->kelas)),
                        'slug' => Str::slug($value->nm_bangsal),
                        'desc' => 'lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                        'price' => $value->trf_kamar,
                        'features' => ['TV', 'AC', 'WiFi', 'Kamar Mandi Dalam', 'Layanan Room Service'],
                    ]
                );

            });
    }
}
