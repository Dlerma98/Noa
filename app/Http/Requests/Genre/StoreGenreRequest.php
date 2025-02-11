<?php

namespace App\Http\Requests\Genre;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|unique:genres|min:4|max:255',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del género es obligatorio.',
            'name.unique' => 'Este género ya existe.',
            'name.min' => 'El nombre debe tener al menos 4 caracteres.',
            'name.max' => 'El nombre debe tener maximo  255 caracteres.',
        ];
    }
}
