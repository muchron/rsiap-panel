<?php

namespace App\Filament\Resources\ScheduleResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\ScheduleResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\ScheduleResource\Api\Transformers\ScheduleTransformer;

class HasDoctorHandler extends Handlers
{
    public static string|null $uri = '/doctors';
    public static string|null $resource = ScheduleResource::class;
    public static bool $public = true;


    /**
     * Show Schedule
     *
     * @param Request $request
     * @return ScheduleTransformer
     */
    public function handler()
    {

        $query = static::getModel()
            ::groupBy('doctor_id')
            ->get();


        if (!$query)
            return static::sendNotFoundResponse();

        // return new ScheduleTransformer($query);
        return self::transform($query);
    }

    public static function transform($data)
    {

        return [
            'success' => true,
            'code' => 200,
            'data' => $data->map(function ($item) {
                return [
                    'id' => $item->doctor->doctor_id,
                    'slug' => $item->doctor->slug,
                    'name' => $item->doctor->user->name,
                ];
            }),
        ];
    }
}
