<?php

namespace App\Filament\Resources\RoomResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
			'name' => 'required',
			'class' => 'required',
			'slug' => 'required',
			'category' => 'required',
			'desc' => 'required|string',
			'price' => 'required',
			'image' => 'required',
			'features' => 'required',
			'color_theme' => 'required',
			'is_available' => 'required',
			'deleted_at' => 'required'
		];
    }
}
