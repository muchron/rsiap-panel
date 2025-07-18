<?php
namespace App\Filament\Resources\ArticlesResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use App\Filament\Resources\ArticlesResource;
use App\Filament\Resources\ArticlesResource\Api\Requests\UpdateArticlesRequest;

class UpdateHandler extends Handlers {
    public static string | null $uri = '/{id}';
    public static string | null $resource = ArticlesResource::class;

    public static function getMethod()
    {
        return Handlers::PUT;
    }

    public static function getModel() {
        return static::$resource::getModel();
    }


    /**
     * Update Articles
     *
     * @param UpdateArticlesRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function handler(UpdateArticlesRequest $request)
    {
        $id = $request->route('id');

        $model = static::getModel()::find($id);

        if (!$model) return static::sendNotFoundResponse();

        $model->fill($request->all());

        $model->save();

        return static::sendSuccessResponse($model, "Successfully Update Resource");
    }
}