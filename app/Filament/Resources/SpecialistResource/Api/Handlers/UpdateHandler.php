<?php
namespace App\Filament\Resources\SpecialistResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\SpecialistResource;
use App\Filament\Resources\SpecialistResource\Api\Requests\UpdateSpecialistRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = SpecialistResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update Specialist
     *
     * @param UpdateSpecialistRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateSpecialistRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}