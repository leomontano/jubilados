<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Barryvdh\Debugbar\Facades\Debugbar;

class SaveAsociadoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
      //  dd($request->user);
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

    // Si la ruta tiene un asociado, es update
    // if ($this->route('asociado')) {
    //     $matriculaRule =   ['required'];
    // } else {
    //     $matriculaRule =  ['required','numeric','between:999,2147483647','unique:asociados'];
    // }

    if ($this->isMethod('PATCH')) {
        $matriculaRule =   ['required'];
    } else {
        $matriculaRule =  ['required','numeric','between:999,2147483647','unique:asociados'];
    }

   // debug('reglas de matricula:',$matriculaRule);

    
        $reglas= [
            'matricula' => $matriculaRule,
            'nombre' => ['required','regex:/^[\pL\s]+$/u','min:2'],
            'apellido' => ['required','regex:/^[\pL\s]+$/u','min:2'],
            'sexo' => 'required|in:M,F',
            'puesto' => 'required|in:J,P',
            'fecha_nacimiento' => [
                    'nullable',
                    'date',
                    'before_or_equal:' . now()->subYears(20)->toDateString(),],
            'fecha_jubilacion' => [
                    'nullable',
                    'date',
                    'before_or_equal:' . now()->subDays(1)->toDateString(),],
          //  'edad' => 'nullable',
          //  'edad_jubilacion' => 'nullable',
            'celular' => 'nullable',
       ];
      //  debug('reglas:',$reglas);
       return $reglas;
    }

    public function messages(): array
    {
         return [
                    'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
                    'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
                    'sexo.in' => 'El sexo debe ser M (Masculino) o F (Femenino).',
                    'sexo.required' => 'El sexo debe ser M (Masculino) o F (Femenino).',
                    'puesto.required' => 'Debes señalar: J (Jubilado) o P (Pensionado).',
                    'puesto.in' => 'El puesto debe ser J (Jubilado) o P (Pensionado).',
                    'fecha_nacimiento.date' => 'La fecha de nacimiento no es válida.',
                    'fecha_nacimiento.before_or_equal' => 'El usuario debe tener al menos 20 años.',
                    'fecha_jubilacion.before_or_equal' => 'La fecha de jubilación debe ser menor al día de hoy',
                ];
    }
}
