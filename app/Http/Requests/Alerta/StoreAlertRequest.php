<?php

namespace App\Http\Requests\Alerta;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlertRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Si usas policies, puedes dejarlo en true porque ya filtras en el controlador con Gate
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'      => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'fecha'       => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es obligatorio.',
            'titulo.max'      => 'El título no debe exceder 255 caracteres.',
            'descripcion.max' => 'La descripción no debe exceder 255 caracteres.',
            'fecha.required'  => 'La fecha es obligatoria.',
            'fecha.date'      => 'La fecha no tiene un formato válido.',
        ];
    }
}
