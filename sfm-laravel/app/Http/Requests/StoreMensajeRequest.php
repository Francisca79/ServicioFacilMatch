<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMensajeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'destinatario_id' => 'nullable|exists:users,id|required_without:profesional_id',
            'profesional_id' => 'nullable|exists:profesionales,id|required_without:destinatario_id',
            'asunto' => 'nullable|string|max:200',
            'cuerpo' => 'required|string|max:2000',
        ];
    }
}
