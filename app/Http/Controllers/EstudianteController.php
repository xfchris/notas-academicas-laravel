<?php

namespace App\Http\Controllers;

use App\Http\Requests\EstudianteRequest;
use App\Models\Estudiante;
use App\Models\Evaluacion;
use App\Models\Nota;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
use Throwable;

class EstudianteController extends Controller
{
    /**
     * Muestra formulario de registro de estudiante
     */
    public function index(){
        $evaluaciones = Evaluacion::get();
        return view('estudiante/formulario', compact('evaluaciones'));
    }

    /**
     * Registra un nuevo estudiante con las calificaciones 
     */
    public function registrarEstudiante(EstudianteRequest $request, Estudiante $estudiante){
        try{
            DB::beginTransaction();
            $data = $request->all();
            
            //Guardo estudiante
            $estudiante->fill($data['estudiante'])->save();
            if (!$estudiante->id){
                throw new Throwable('Se presentó un error al guardar estudiante en SQL');
            }

            //Guardo notas de estudiante
            $notas = [];
            foreach ($data['evaluacion'] as $key => $nota) {
                $notas[] = ['estudiante_id'=>$estudiante->id, 'evaluacion_id'=>$key, 'calificacion'=>$nota];
            }
            if (!Nota::insert($notas)){
                throw new Throwable("Se presento un error al guardar las notas del estudiante");
            }
            $codigo = 'success';
            $msg = Lang::get('web.estudiante.msg.success');
            DB::commit();

        }catch(Throwable $e){
            DB::rollBack();

            Log::error($e->getMessage());
            $codigo = 'error';
            $msg = 'Se presentó un error interno, no se pudo registrar el estudiante';
        }
        
        //Guardo evaluacion
        return redirect(route('formulario'))->with($codigo, $msg);
    }

    /**
     * Muestra el reporte detallado de cada uno de los estudiantes y el porcentaje de logro total
     */
    public function mostrarReporte(){
        $evaluaciones = Evaluacion::get();
        $estudiantes = Estudiante::select('id','nombres','apellidos','fechaNacimiento')->with('notas')->get();

        $porcentajeTotal = 0;
        foreach ($estudiantes as $estudiante) {
            $estudiante->generarCalificaciones($evaluaciones);
            $porcentajeTotal += $estudiante->porcentajeTotal;
        }
        if (count($estudiantes)){
            $porcentajeTotal = round($porcentajeTotal/count($estudiantes),1);
        }
        return view('estudiante/reportes', compact('evaluaciones', 'estudiantes', 'porcentajeTotal'));
    }
}
