<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfesionalProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isProfesional();
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:100',
            'especialidad' => 'required|string|max:150',
            'precio_min' => 'required|numeric|min:0',
            'precio_max' => 'required|numeric|gte:precio_min',
            'descripcion' => 'nullable|string|max:2000',
            'categoria_id' => 'required|exists:categorias,id',
            'telefono' => 'nullable|string|max:20',
            'ciudad' => 'nullable|string|max:100|in:San Miguel',
            'experiencia' => 'nullable|string|max:100',
            'modalidad' => 'nullable|string|max:50',
            'disponibilidad' => 'nullable|string|max:100',
            'foto_archivo' => 'nullable|image|max:2048',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'precio_estimado' => $this->precio_min,
        ]);
    }
}
