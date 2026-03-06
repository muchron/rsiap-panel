<?php

namespace App\Filament\Resources\RoomResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\RoomResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\RoomResource\Api\Transformers\RoomTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = RoomResource::class;


    /**
     * Show Room
     *
     * @param Request $request
     * @return RoomTransformer
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

        return new RoomTransformer($query);
    }
}
