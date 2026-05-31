<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResenaClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isProfesional();
    }

    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:users,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
        ];
    }
}
