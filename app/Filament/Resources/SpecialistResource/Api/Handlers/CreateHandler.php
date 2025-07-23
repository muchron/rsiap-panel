<?php
namespace App\Filament\Resources\SpecialistResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\SpecialistResource;
use App\Filament\Resources\SpecialistResource\Api\Requests\CreateSpecialistRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = SpecialistResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Specialist
     *
     * @param CreateSpecialistRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateSpecialistRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}