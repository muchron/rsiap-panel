<?php
namespace App\Filament\Resources\SpecialistResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\SpecialistResource;
use Illuminate\Routing\Router;


class SpecialistApiService extends ApiService
{
    protected static string | null $resource = SpecialistResource::class;

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
