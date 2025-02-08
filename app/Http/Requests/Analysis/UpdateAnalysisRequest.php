<?php

namespace App\Http\Requests\Analysis;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnalysisRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:10|max:255',
            'content' => 'required|string|min:10|max:500',
            'score' => 'required|min:0|max:100',
            'console' => 'required|string|in:PlayStation,Xbox,PC,Switch',
            'type' => 'required|string|in:Review,Retro,News',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'title.min' => 'El título debe tener al menos 10 caracteres.',
            'title.max' => 'El título no puede superar los 255 caracteres.',


            'content.required' => 'El contenido es obligatorio.',
            'content.min' => 'El contenido debe tener al menos 30 caracteres.',

            'score.required' => 'El extracto es obligatorio.',

            'console.required' => 'La categoría es obligatoria.',
            'console.in' => 'La categoría debe ser una de las siguientes: PlayStation, Xbox, PC, Switch.',

            'type.required' => 'El tipo es obligatorio.',
            'type.in' => 'El tipo debe ser Review, Retro o News.',

            'thumbnail.image' => 'El archivo debe ser una imagen.',
            'thumbnail.mimes' => 'El formato de imagen debe ser jpeg, png, jpg, gif o webp.',
            'thumbnail.max' => 'El tamaño de la imagen no puede superar los 2MB.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
