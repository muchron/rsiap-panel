<?php
namespace App\Filament\Resources\SpecialistResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Specialist;
use Illuminate\Support\Facades\Storage;

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
            'is_polyclinic' => $this->is_polyclinic,
            'doctors_count' => $this->doctors->count(),
            'doctors' => $this->doctors->map(function ($doctor) {
                return [
                    'id' => $doctor->doctor_id,
                    'name' => $doctor->user->name,
                    'slug' => $doctor->slug,
                    'polyclinic' => $doctor->polyclinic,
                    'photo' => asset(Storage::url($doctor->photo)   ),
                ];
            }),
        ];
    }
}
