<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|unique:users,email',
            'contrasena' => 'required|string|min:6|confirmed',
            'telefono' => 'nullable|string|max:20',
            'ciudad' => 'nullable|string|max:100',
        ];
    }
}
