<?php

namespace App\Http\Requests\Analysis;

use Illuminate\Foundation\Http\FormRequest;
use Livewire\WithFileUploads;

class StoreAnalysisRequest extends FormRequest
{
    use WithFileUploads; // Para que funcione con Livewire

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:10|max:255',
            'content' => 'required|string|min:10|max:500',
            'score' => 'required|integer|min:0|max:100',
            'console' => 'required|string|in:PlayStation,Xbox,PC,Switch',
            'type' => 'required|string|in:Review,Retro,News',
            'genre_id' => 'required|exists:genres,id',
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

            'genre_id.required' => 'El género es obligatorio.', // 💡 Mensaje nuevo
            'genre_id.exists' => 'El género seleccionado no es válido.',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
