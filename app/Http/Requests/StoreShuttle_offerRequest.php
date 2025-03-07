<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShuttle_offerRequest extends FormRequest
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
            "title" => "required|string|max:255",
            "depart" => "required|string",
            "arrivee" => "required|string",
            "heure_depart" => "required|date_format:H:i",
            "heure_arrivee" => "required|date_format:H:i",
            "date_debut" => "required|date",
            "date_fin" => "required|date",
            "available_places" => "required|integer|min:1",
            "description" => "nullable|string"
        ];
    }
}
