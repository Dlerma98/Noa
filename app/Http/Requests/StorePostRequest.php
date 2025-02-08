<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'=>'required|min:10',
            'excerpt'=>'required|min:10',
            'content'=>'required|min:30',
            'category'=>'required',
            'type'=>'required',
            'thumbnail'=>'nullable|image|max:2048',

        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
