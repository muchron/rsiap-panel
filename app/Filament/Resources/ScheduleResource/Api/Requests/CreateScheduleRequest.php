<?php

namespace App\Filament\Resources\ScheduleResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
			'doctor_id' => 'required',
			'day' => 'required',
			'start_at' => 'required',
			'end_at' => 'required',
			'polyclinic_code' => 'required',
			'deleted_at' => 'required'
		];
    }
}
