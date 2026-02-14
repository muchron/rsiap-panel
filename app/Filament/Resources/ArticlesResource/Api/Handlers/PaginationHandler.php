<?php
namespace App\Filament\Resources\ArticlesResource\Api\Handlers;

use Illuminate\Http\Request;
use Rupadana\ApiService\Http\Handlers;
use Spatie\QueryBuilder\QueryBuilder;
use App\Filament\Resources\ArticlesResource;
use App\Filament\Resources\ArticlesResource\Api\Transformers\ArticlesTransformer;

class PaginationHandler extends Handlers
{
    public static string|null $uri = '/';
    public static string|null $resource = ArticlesResource::class;
    public static bool $public = true;



    /**
     * List of Articles
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function handler()
    {
        $query = static::getEloquentQuery();

        $query = $this->applyQueryBuilder($query);

        $limit = request()->query('limit');
        $random = request()->boolean('random');
        $category = request()->query('category');

        if ($random && $limit) {
            return $this->getRandomArticles($query, $limit);
        }

        if ($limit) {
            return $this->getLimitedArticles($query, $limit);
        }

        if ($category) {
            return $this->getByCategory($query);
        }

        return $this->getPaginatedArticles($query);
    }

    protected function applyQueryBuilder($query)
    {
        return QueryBuilder::for($query)
            ->isPublished()
            ->allowedFields($this->getAllowedFields() ?? [])
            ->allowedSorts($this->getAllowedSorts() ?? [])
            ->allowedFilters($this->getAllowedFilters() ?? [])
            ->allowedIncludes($this->getAllowedIncludes() ?? []);
    }

    protected function getRandomArticles($query, $limit)
    {
        $data = $query
            ->orderByDesc('views')
            ->limit(50)
            ->get()
            ->shuffle()
            ->take($limit);

        return ArticlesTransformer::collection($data);
    }

    protected function getLimitedArticles($query, $limit)
    {
        $data = $query
            ->orderByDesc('views')
            ->limit($limit)
            ->get();

        return ArticlesTransformer::collection($data);
    }

    protected function getPaginatedArticles($query)
    {
        $data = $query
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return ArticlesTransformer::collection($data);
    }

    protected function getByCategory($query)
    {
        $data = $query
            ->whereHas('category', function ($query) {
                $query->where('slug', request()->query('category'));
            })
            ->paginate(request()->query('per_page', 10))
            ->appends(request()->query());

        return ArticlesTransformer::collection($data);
    }
}
