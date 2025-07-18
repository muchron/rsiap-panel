<?php
namespace App\Filament\Resources\ArticlesResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\ArticlesResource;
use App\Filament\Resources\ArticlesResource\Api\Requests\CreateArticlesRequest;

class CreateHandler extends Handlers {
    public static string | null $uri = '/';
    public static string | null $resource = ArticlesResource::class;

    public static function getMethod()
    {
        return Handlers::POST;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }

    /**
     * Create Articles
     *
     * @param CreateArticlesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(CreateArticlesRequest $request)
    {
        $model = new (static::getModel());

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Create Resource");
    }
}