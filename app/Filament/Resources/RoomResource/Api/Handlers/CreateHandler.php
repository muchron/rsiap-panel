<?php
namespace App\Filament\Resources\RoomResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\RoomResource;
use App\Filament\Resources\RoomResource\Api\Requests\CreateRoomRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = RoomResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Room
     *
     * @param CreateRoomRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateRoomRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}