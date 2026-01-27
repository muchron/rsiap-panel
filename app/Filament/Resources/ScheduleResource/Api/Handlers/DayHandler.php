<?php

namespace App\Filament\Resources\ScheduleResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\ScheduleResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\ScheduleResource\Api\Transformers\ScheduleTransformer;

class DayHandler extends Handlers
{
    public static string|null $uri = '/day/{day}';
    public static string|null $resource = ScheduleResource::class;
    public static bool $public = true;

    public function handler(Request $request)
    {
        $hariInput = strtoupper($request->route('day'));

        $query = static::getEloquentQuery();

        $model = QueryBuilder::for($query)
            ->where('day', $hariInput)
            ->with(['doctor.user', 'polyclinic'])
            ->orderByRaw("FIELD(day, 'SENIN', 'SELASA', 'RABU', 'KAMIS', 'JUMAT', 'SABTU', 'MINGGU')")
            ->orderBy('start_at', 'asc')
            ->get();

        return self::transform($model);
    }

    public static function transform($data)
    {
        return [
            'success' => true,
            'code' => 200,
            'message' => 'Berhasil mengambil jadwal hari ' . request()->route('day'),
            'data' => $data->map(function ($item) {
                return [
                    'slug' => $item->doctor->slug ?? '-',
                    'name' => $item->doctor->user->name ?? '-',
                    'day' => $item->day,
                    'polyclinic' => $item->polyclinic->name ?? '-',
                    'start_at' => $item->start_at,
                    'end_at' => $item->end_at
                ];
            }),
        ];
    }
}
