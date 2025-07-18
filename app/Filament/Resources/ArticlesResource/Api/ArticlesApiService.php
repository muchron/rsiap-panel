<?php
namespace App\Filament\Resources\ArticlesResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\ArticlesResource;
use Illuminate\Routing\Router;


class ArticlesApiService extends ApiService
{
    protected static string|null $resource = ArticlesResource::class;

    public static function handlers(): array
    {
        return [
            Handlers\CreateHandler::class,
            Handlers\UpdateHandler::class,
            Handlers\DeleteHandler::class,
            Handlers\PaginationHandler::class,
            Handlers\DetailHandler::class
        ];

    }
}
