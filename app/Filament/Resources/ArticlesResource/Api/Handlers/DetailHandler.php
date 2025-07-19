<?php

namespace App\Filament\Resources\ArticlesResource\Api\Handlers;

use App\Filament\Resources\SettingResource;
use App\Filament\Resources\ArticlesResource;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use App\Filament\Resources\ArticlesResource\Api\Transformers\ArticlesTransformer;

class DetailHandler extends Handlers
{
    public static string|null $uri = '/{id}';
    public static string|null $resource = ArticlesResource::class;
    public static bool $public = true;


    /**
     * Show Articles
     *
     * @param Request $request
     * @return ArticlesTransformer
     */
    public function handler(Request $request)
    {
        $id = $request->route('id');

        $query = static::getEloquentQuery();

        // dd($query);
        $query = QueryBuilder::for(
            $query->where(['slug' => $id])
        )->where('status', 'published')
            ->first();

        if (!$query)
            return static::sendNotFoundResponse();

        return new ArticlesTransformer($query);
    }
}
