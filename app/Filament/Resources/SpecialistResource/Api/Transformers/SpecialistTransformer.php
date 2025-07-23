<?php
namespace App\Filament\Resources\SpecialistResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Specialist;

/**
 * @property Specialist $resource
 */
class SpecialistTransformer extends JsonResource
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
            'slug' => $this->slug,
            'name' => $this->name,
            'doctors_count' => $this->doctor->count(),
            'doctors' => $this->doctor->map(function ($doctor) {
                return [
                    'id' => $doctor->doctor_id,
                    'name' => $doctor->user->name,
                    'slug' => $doctor->slug,
                ];
            }),
        ];
    }
}
