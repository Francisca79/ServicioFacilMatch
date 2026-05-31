<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PanelContactoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isCliente();
    }

    public function rules(): array
    {
        return [
            'profesional_id' => 'required|exists:profesionales,id',
            'mensaje' => 'required|string|max:2000',
        ];
    }
}
