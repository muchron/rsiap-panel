<?php
namespace App\Filament\Resources\RoomResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Resources\RoomResource;
use App\Filament\Resources\RoomResource\Api\Transformers\RoomTransformer;

class PaginationHandler extends Handlers
{
    public static string|null $uri = '/';
    public static string|null $resource = RoomResource::class;
    public static bool $public = true;
    /**
     * List of Room
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function handler()
    {
        $query = static::getEloquentQuery();


        if (request()->query('class')) {
            $query->where('class', request()->query('class'));
        }
        $query = QueryBuilder::for($query)
            ->allowedFields($this->getAllowedFields() ?? [])
            ->allowedSorts($this->getAllowedSorts() ?? [])
            ->allowedFilters($this->getAllowedFilters() ?? [])
            ->allowedIncludes($this->getAllowedIncludes() ?? [])
            ->paginate(request()->query('per_page'))
            ->appends(request()->query());

        $query->each(function ($room) {
            if ($room->image) {
                $room->image = asset('storage/' . $room->image);
            }
        });


        return RoomTransformer::collection($query);
    }
}
