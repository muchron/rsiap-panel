<?php
namespace App\Filament\Resources\CarouselResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Carousel;
use Illuminate\Support\Facades\Storage;

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
        $this->resource->image = asset(Storage::url($this->resource->image));
        return $this->resource->toArray();
    }
}
