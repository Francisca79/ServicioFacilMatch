<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientePerfilRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isCliente();
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'foto_archivo' => 'nullable|image|max:2048',
        ];
    }
}
