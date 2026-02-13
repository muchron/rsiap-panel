<?php

namespace App\Filament\Resources\CarouselResource\Api\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCarouselRequest extends FormRequest
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
			'title' => 'required',
			'image' => 'required',
			'is_active' => 'required',
			'deleted_at' => 'required'
		];
    }
}
