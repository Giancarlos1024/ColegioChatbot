<?php

namespace App\Http\Requests\Alerta;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlertRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo'      => ['sometimes', 'required', 'string', 'max:255'],
            'descripcion' => ['sometimes', 'nullable', 'string', 'max:255'],
            'fecha'       => ['sometimes', 'required', 'date'],
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
