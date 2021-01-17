<?php

namespace Database\Seeders;

use App\Models\Evaluacion;
use Illuminate\Database\Seeder;

class EvaluacionesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Evaluacion::insert([
            ['titulo'=>'Evaluación diagnóstica'],
            ['titulo'=>'Evaluación trimestral'],
            ['titulo'=>'Evaluación final']
        ]);
    }
}
