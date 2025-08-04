<?php

namespace App\Filament\Resources\DoctorResource\Api\Handlers;

use App\Filament\Resources\DoctorResource;
use App\Filament\Resources\DoctorResource\Api\Transformers\DoctorTransformer;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;

class CustomHandler extends Handlers
{
    public static string|null $uri = '/list';
    public static string|null $resource = DoctorResource::class;
    public static bool $public = true;

    public function handler()
    {
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for($query)
            ->get();

        return DoctorTransformer::collection($query);
    }
}
