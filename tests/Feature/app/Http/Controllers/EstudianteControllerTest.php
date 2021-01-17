<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Models\Estudiante;
use App\Models\Evaluacion;
use App\Models\Nota;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class EstudianteControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed('EvaluacionesSeeder');
    }

    /**
     * @test
     */
    public function verificar_que_redirige_a_la_web_del_formulario()
    {
        $res = $this->get('/');
        $res->assertStatus(302);
    }
    
    /**
     * @test
     */
    public function verificar_que_se_muestra_formulario(){
        $res = $this->get(route('formulario'));
        $res->assertStatus(200);
        $res->assertSee('Nuevo estudiante');
    }

    /**
     * @test
     */
    public function verificar_que_no_permite_registrar_estudiante_con_datos_incorrectos(){
        $evaluaciones = Evaluacion::get();
        $notas = [];
        foreach ($evaluaciones as $evaluacion) {
            $notas[$evaluacion->id] = rand(1, config('constants.notaMaxima'));
        }
        $data = [
                'estudiante' =>[
                    'nombres' => 'Chris',
                    'apellidos' => 'Vale',
                    'fechaNacimiento' => 'fecha-falsa'
                ],
                'evaluacion'=> $notas
        ];
        $res = $this->post(route('registrarEstudiante'), $data);
        $res->assertStatus(302);
        $res->assertSessionHasErrors('estudiante.fechaNacimiento');
    }

    /**
     * @test
     */
    public function verificar_que_se_registra_estudiante_con_sus_calificaciones(){
        $evaluaciones = Evaluacion::get();
        $notas = [];
        foreach ($evaluaciones as $evaluacion) {
            $notas[$evaluacion->id] = rand(1, config('constants.notaMaxima'));
        }
        $data = [
                'estudiante' =>[
                    'nombres' => 'Chris',
                    'apellidos' => 'Vale',
                    'fechaNacimiento' => '2020-10-21'
                ],
                'evaluacion'=> $notas
        ];
        $res = $this->followingRedirects()->post(route('registrarEstudiante'), $data);
        $res->assertStatus(200);

        //compruebo que el registo exista en base de datos
        $this->assertDatabaseHas('estudiantes', $data['estudiante']);

        //compruebo que mueste al usuario el mensaje de registro exitoso
        $res->assertSee(Lang::get('web.estudiante.msg.success'));

    }

    /**
     * @test
     */
    public function verificar_que_se_muestra_reporte_de_estudiantes(){
        $estudiantes = Estudiante::factory(2)->create();
        $evaluaciones = Evaluacion::get();

        $notas = [];
        foreach ($estudiantes as $estudiante) {
            foreach ($evaluaciones as $evaluacion) {
                $notas[] = [
                    'estudiante_id'=>$estudiante->id, 
                    'evaluacion_id'=>$evaluacion->id, 
                    'calificacion'=>rand(1, config('constants.notaMaxima'))
                ];
            }            
        }
        Nota::insert($notas);
       
        $res = $this->get(route('reportes'));
        $res->assertStatus(200);

        foreach ($estudiantes as $estudiante) {
            $res->assertSee($estudiante->nombres)
            ->assertSee($estudiante->apellidos)
            ->assertSee($estudiante->getFechaNacimiento());

            foreach ($evaluaciones as $k=>$evaluacion) {
                $res->assertSee('Calificación: '.$estudiante->notas->get($k)->calificacion);
            }
        }
    }
}
