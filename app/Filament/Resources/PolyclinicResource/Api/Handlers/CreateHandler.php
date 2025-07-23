<?php
namespace App\Filament\Resources\PolyclinicResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\PolyclinicResource;
use App\Filament\Resources\PolyclinicResource\Api\Requests\CreatePolyclinicRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = PolyclinicResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Polyclinic
     *
     * @param CreatePolyclinicRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreatePolyclinicRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}