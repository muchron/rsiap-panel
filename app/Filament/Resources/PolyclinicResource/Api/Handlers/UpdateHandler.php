<?php
namespace App\Filament\Resources\PolyclinicResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\PolyclinicResource;
use App\Filament\Resources\PolyclinicResource\Api\Requests\UpdatePolyclinicRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = PolyclinicResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update Polyclinic
     *
     * @param UpdatePolyclinicRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdatePolyclinicRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}