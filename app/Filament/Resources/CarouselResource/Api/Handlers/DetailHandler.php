<?php

namespace App\Filament\Resources\CarouselResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\CarouselResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\CarouselResource\Api\Transformers\CarouselTransformer;

class DetailHandler extends Handlers
{
    public static string | null $uri = '/{id}';
    public static string | null $resource = CarouselResource::class;


    /**
     * Show Carousel
     *
     * @param Request $request
     * @return CarouselTransformer
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

        return new CarouselTransformer($query);
    }
}
