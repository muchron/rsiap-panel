<?php
namespace App\Filament\Resources\PolyclinicResource\Api\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Polyclinic;

/**
 * @property Polyclinic $resource
 */
class PolyclinicTransformer extends JsonResource
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
            'schedules' => $this->schedules->groupBy('doctor.slug')->map(function ($schedule) {
                return [
                    'doctor_id' => $schedule->first()->doctor->slug,
                    'name' => $schedule->first()->doctor->user->name,
                    'schedules' => $schedule->map(function ($item) {
                        return [
                            'day' => $item->day,
                            'start_at' => $item->start_at,
                            'end_at' => $item->end_at,
                        ];
                    }),
                ];
            }),
        ];
    }
}
