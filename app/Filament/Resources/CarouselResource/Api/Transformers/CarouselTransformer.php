<?php
namespace App\Filament\Resources\CarouselResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Carousel;

/**
 * @property Carousel $resource
 */
class CarouselTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->resource->toArray();
    }
}
