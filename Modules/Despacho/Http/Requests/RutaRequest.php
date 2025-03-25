<?php

namespace Modules\Despacho\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class RutaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Ajusta esto según tu lógica de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'origen' => 'required|string|max:100',
            'destino' => 'required|string|max:100',
            'distancia' => 'required|numeric|min:0',
            'tiempo_estimado' => 'required|integer|min:1',
            'activo' => 'boolean'
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la ruta es obligatorio',
            'origen.required' => 'El origen de la ruta es obligatorio',
            'destino.required' => 'El destino de la ruta es obligatorio',
            'distancia.required' => 'La distancia de la ruta es obligatoria',
            'distancia.numeric' => 'La distancia debe ser un valor numérico',
            'tiempo_estimado.required' => 'El tiempo estimado es obligatorio',
            'tiempo_estimado.integer' => 'El tiempo estimado debe ser un valor entero',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Error de validación',
            'errors' => $validator->errors()
        ], 422));
    }
}
