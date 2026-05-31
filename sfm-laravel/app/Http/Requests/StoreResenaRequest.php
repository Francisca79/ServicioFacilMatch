<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResenaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profesional_id' => 'required|exists:profesionales,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
            'nombre' => 'required|string|max:100',
        ];
    }
}
