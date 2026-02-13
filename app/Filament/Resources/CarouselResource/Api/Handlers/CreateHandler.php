<?php
namespace App\Filament\Resources\CarouselResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\CarouselResource;
use App\Filament\Resources\CarouselResource\Api\Requests\CreateCarouselRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = CarouselResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Carousel
     *
     * @param CreateCarouselRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateCarouselRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}