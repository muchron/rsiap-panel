<?php
namespace App\Filament\Resources\PolyclinicResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\PolyclinicResource;
use Illuminate\Routing\Router;


class PolyclinicApiService extends ApiService
{
    protected static string | null $resource = PolyclinicResource::class;

    public static function handlers() : array
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
