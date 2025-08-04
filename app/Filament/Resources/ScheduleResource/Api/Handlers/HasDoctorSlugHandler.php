<?php

namespace App\Filament\Resources\ScheduleResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\ScheduleResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\ScheduleResource\Api\Transformers\ScheduleTransformer;

class HasDoctorSlugHandler extends Handlers
{
    public static string|null $uri = '/doctors/{slug}';
    public static string|null $resource = ScheduleResource::class;
    public static bool $public = true;


    /**
     * Show Schedule
     *
     * @param Request $request
     * @return ScheduleTransformer
     */
    public function handler(Request $request)
    {
        $param = $request->route('slug');
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where('slug', $param)
        )
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
            'data' =>
                $data->map(function ($item) {
                    return [
                        'slug' => $item->doctor->slug,
                        'name' => $item->doctor->user->name,
                        'polyclinic' => $item->polyclinic->name,
                        'start_at' => $item->start_at,
                        'end_at' => $item->end_at
                    ];
                }),
        ];
    }
}
