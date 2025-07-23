<?php

namespace App\Filament\Resources\DoctorResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\DoctorResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\DoctorResource\Api\Transformers\DoctorTransformer;

class DetailHandler extends Handlers
{
    public static string|null $uri = '/{id}';
    public static string|null $resource = DoctorResource::class;
    public static bool $public = true;


    /**
     * Show Doctor
     *
     * @param Request $request
     * @return DoctorTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');

        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where('slug', $id)
        )
            ->first();

        if (!$query)
            return static::sendNotFoundResponse();

        return new DoctorTransformer($query);
    }
}
