<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => 'required|string|min:10|max:255',
            'excerpt' => 'required|string|min:10|max:500',
            'content' => 'required|string|min:30',
            'category' => 'required|string|in:PlayStation,Xbox,PC,Switch',
            'type' => 'required|string|in:Exclusive,Multiplatform',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio.',
            'title.min' => 'El título debe tener al menos 10 caracteres.',
            'title.max' => 'El título no puede superar los 255 caracteres.',

            'excerpt.required' => 'El extracto es obligatorio.',
            'excerpt.min' => 'El extracto debe tener al menos 10 caracteres.',
            'excerpt.max' => 'El extracto no puede superar los 500 caracteres.',

            'content.required' => 'El contenido es obligatorio.',
            'content.min' => 'El contenido debe tener al menos 30 caracteres.',

            'category.required' => 'La categoría es obligatoria.',
            'category.in' => 'La categoría debe ser una de las siguientes: PlayStation, Xbox, PC, Switch.',

            'type.required' => 'El tipo es obligatorio.',
            'type.in' => 'El tipo debe ser Exclusive o Multiplatform.',

            'thumbnail.image' => 'El archivo debe ser una imagen.',
            'thumbnail.mimes' => 'El formato de imagen debe ser jpeg, png, jpg, gif o webp.',
            'thumbnail.max' => 'El tamaño de la imagen no puede superar los 2MB.',
        ];
    }
}
