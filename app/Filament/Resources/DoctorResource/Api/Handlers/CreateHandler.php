<?php
namespace App\Filament\Resources\DoctorResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\DoctorResource;
use App\Filament\Resources\DoctorResource\Api\Requests\CreateDoctorRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = DoctorResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Doctor
     *
     * @param CreateDoctorRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateDoctorRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}