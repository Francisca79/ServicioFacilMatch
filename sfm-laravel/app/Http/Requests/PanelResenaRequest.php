<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PanelResenaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isCliente();
    }

    public function rules(): array
    {
        return [
            'profesional_id' => 'required|exists:profesionales,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|max:1000',
        ];
    }
}
