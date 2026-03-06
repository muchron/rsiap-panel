<?php
namespace App\Filament\Resources\RoomResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\RoomResource;
use Illuminate\Routing\Router;


class RoomApiService extends ApiService
{
    protected static string | null $resource = RoomResource::class;

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
