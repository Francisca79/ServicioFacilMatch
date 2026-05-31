<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'profesional_id' => 'required|exists:profesionales,id',
            'nombre' => 'required|string|max:100',
            'correo' => 'required|email|max:100',
            'mensaje' => 'required|string|max:2000',
        ];
    }
}
