<?php
namespace App\Filament\Resources\RoomResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Room;

/**
 * @property Room $resource
 */
class RoomTransformer extends JsonResource
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
