<?php

namespace App\Http\Requests;

use App\Models\Evaluacion;
use Illuminate\Foundation\Http\FormRequest;

class EstudianteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        $reglas = [
            'estudiante.nombres' => 'required|max:120',
            'estudiante.apellidos' => 'required|max:120',
            'estudiante.fechaNacimiento' => 'required|date|date_format:Y-m-d'
        ];
        $reglas += $this->getEvaluaciones('required|numeric|between:1,'.config('constants.notaMaxima'));
        return $reglas;
    }

     /**
     * Return the attributes with your real name
     *
     * @return string[]
     */
    public function attributes()
    {
        $a = [
            'estudiante.nombres' => 'nombre',
            'estudiante.apellidos' => 'apellido',
            'estudiante.fechaNacimiento' => 'Fecha de nacimiento'
        ];
        $a += $this->getEvaluaciones();
        return $a;
    }

    /**
     * Devuelve los campos dinámicos de cada una de las evaluaciones
     * 
     * @return string[]
     */
    private function getEvaluaciones($reglas=null){
        $totalEvaluaciones = Evaluacion::select('id', 'titulo')->get();
        $reglasEvaluaciones = [];
        foreach ($totalEvaluaciones as $e) {
            $data = ($reglas)?:$e->titulo;
           $reglasEvaluaciones['evaluacion.'.$e->id] = $data;
        }
        return $reglasEvaluaciones;
    }
}
