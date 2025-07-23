<?php
namespace App\Filament\Resources\PolyclinicResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Resources\PolyclinicResource;
use App\Filament\Resources\PolyclinicResource\Api\Transformers\PolyclinicTransformer;

class PaginationHandler extends Handlers
{
    public static string|null $uri = '/';
    public static string|null $resource = PolyclinicResource::class;
    public static bool $public = true;


    /**
     * List of Polyclinic
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function handler()
    {

        $query = \App\Models\Polyclinic::with(['schedules', 'schedules.doctor'])
            ->whereHas('schedules.doctor');



        // $query = static::getEloquentQuery();

        $query = QueryBuilder::for($query)
            ->allowedFields($this->getAllowedFields() ?? [])
            ->allowedSorts($this->getAllowedSorts() ?? [])
            ->allowedFilters($this->getAllowedFilters() ?? [])
            ->allowedIncludes($this->getAllowedIncludes() ?? [])
            ->paginate(request()->query('per_page'))
            ->appends(request()->query());

        return PolyclinicTransformer::collection($query);
    }
}
