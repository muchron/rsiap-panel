<?php
namespace App\Filament\Resources\DoctorResource\Api;

use Rupadana\ApiService\ApiService;
use App\Filament\Resources\DoctorResource;
use Illuminate\Routing\Router;


class DoctorApiService extends ApiService
{
    protected static string | null $resource = DoctorResource::class;

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
