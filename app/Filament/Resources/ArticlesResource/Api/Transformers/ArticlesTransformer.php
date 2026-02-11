<?php
namespace App\Filament\Resources\ArticlesResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Articles;
use Illuminate\Support\Facades\Storage;

/**
 * @property Articles $resource
 */
class ArticlesTransformer extends JsonResource
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
            // 'id' => $this->resource->id,
            'slug' => $this->resource->slug,
            'title' => $this->resource->title,
            'body' => $this->resource->body,
            'cover' => Storage::url($this->resource->cover),
            'author' => $this->resource->user->name,
            'category' => [
                'name' => $this->resource->category->name,
                'slug' => $this->resource->category->slug
            ],
            'labels' => $this->resource->labels->map(function ($label) {
                return [
                    'name' => $label->name,
                    'slug' => $label->slug,
                ];
            })->toArray(),
            'status' => $this->resource->status,
            'views' => $this->resource->view,
            'created_at' => $this->resource->created_at,

        ];


    }
}
