<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    /**
     * Notas registradas
     */
    public function notas(){
        return $this->hasMany('App\Models\Nota');
    }

    public function setNombresAttribute($value){
        $this->attributes['nombres'] = ucwords(strtolower($value));
    }

    public function setApellidosAttribute($value){
        $this->attributes['apellidos'] = ucwords(strtolower($value));
    }


    /**
     * Crea los atributos "calificaciones" y "porcentajeTotal" en el modelo instanciado con porcentajes de logro
     */
    public function generarCalificaciones($evaluaciones){
        $notaMaxima = config('constants.notaMaxima');
        $evaluacionTotal = 0;
        $res = [];
        foreach ($evaluaciones as $key => $evaluacion) {
            $cal = ($this->notas->count())?($this->notas->get($key)?$this->notas->get($key)->calificacion:0):0;
            $por = round(($cal*100/$notaMaxima), 1);
            $res [$key] = ['evaluacion_id'=>$evaluacion->id, 'calificacion'=>$cal, 'porcentaje'=>$por];
            $evaluacionTotal += $por;
        }
        $this->calificaciones =  $res;
        $this->porcentajeTotal = round($evaluacionTotal/count($evaluaciones),1);
    }

    /**
     * Devuelve la fecha de nacimiento en formato latino
     */
    public function getFechaNacimiento(){
        $f =$this->fechaNacimiento;
        return preg_replace("/([0-9]{4})-([0-9]{2})-([0-9]{2})/", "$3/$2/$1", $f);
    }
    
}
