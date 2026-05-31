<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfesionalRequest extends FormRequest
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
            'categoria_id' => 'required|exists:categorias,id',
            'especialidad' => 'required|string|max:150',
            'experiencia' => 'nullable|string|max:100',
            'precio_estimado' => 'required|numeric|min:0',
            'modalidad' => 'nullable|string|max:50',
            'disponibilidad' => 'nullable|string|max:100',
            'foto_archivo' => 'nullable|image|max:2048',
            'descripcion' => 'nullable|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'correo.unique' => 'Este correo ya está registrado.',
            'contrasena.confirmed' => 'Las contraseñas no coinciden.',
        ];
    }
}
