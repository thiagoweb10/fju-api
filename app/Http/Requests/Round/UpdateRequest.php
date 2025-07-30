<?php

namespace App\Http\Requests\Round;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'championship_id' => 'required|exists:championships,id',
            'date_round' => 'required',
            'round_number' => 'required|int',
            'status_rounds_id' => 'required|exists:status_rounds,id',
        ];
    }
}
