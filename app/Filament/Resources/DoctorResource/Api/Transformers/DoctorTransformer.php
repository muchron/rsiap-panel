<?php
namespace App\Filament\Resources\DoctorResource\Api\Transformers;

use App\Models\Schedule;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Doctor;

/**
 * @property Doctor $resource
 */
class DoctorTransformer extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = $this->resource;


        return [
            'id' => $resource->doctor_id,
            'slug' => $resource->slug,
            'name' => $resource->user?->name,
            'specislist' => [
                'name' => $resource->specialist()->first()->name,
                'slug' => $resource->specialist()->first()->slug,
            ],
            'about' => $resource->about,
            'photo' => $resource->photo,
            'polyclinic' => $resource->polyclinic,
            'schedule' => $resource->schedules()->get()->map(function (Schedule $schedule) use ($resource) {
                return [
                    'day' => $schedule->day,
                    'polyclinic' => $schedule->polyclinic?->name,
                    'slug' => $schedule->polyclinic?->slug,
                    'start_at' => $schedule->start_at,
                    'end_at' => $schedule->end_at,
                ];
            })

        ];
    }
}
