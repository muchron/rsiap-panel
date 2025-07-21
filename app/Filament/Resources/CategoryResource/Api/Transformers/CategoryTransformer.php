<?php
namespace App\Filament\Resources\CategoryResource\Api\Transformers;

use App\Filament\Resources\ArticlesResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Categories;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @property Category $resource
 */
class CategoryTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->resource->name,
            'slug' => $this->resource->slug,
            'count' => $this->resource->articles()->isPublished()->count(),
            'articles' => $this->resource->articles()->isPublished()->get()->map(function ($article) {
                return [
                    'slug' => $article->slug,
                    'title' => $article->title,
                    'author' => $article->user->name,
                    'cover' => env('APP_URL') . Storage::url($article->cover),
                    'status' => $article->status,
                    'body' => Str::limit($article->body, 100),
                    'created_at' => $article->created_at,

                ];
            }),
        ];
    }
}
