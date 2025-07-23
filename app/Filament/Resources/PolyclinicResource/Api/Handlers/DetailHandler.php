<?php

namespace App\Filament\Resources\PolyclinicResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\PolyclinicResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\PolyclinicResource\Api\Transformers\PolyclinicTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = PolyclinicResource::class;


    /**
     * Show Polyclinic
     *
     * @param Request $request
     * @return PolyclinicTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');
        
        $query = static::getEloquentQuery();

        $query = QueryBuilder::for(
            $query->where(static::getKeyName(), $id)
        )
            ->first();

        if (!$query) return static::sendNotFoundResponse();

        return new PolyclinicTransformer($query);
    }
}
