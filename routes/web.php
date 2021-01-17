<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('formulario'));
});


Route::get('/estudiante', [App\Http\Controllers\EstudianteController::class, 'index'])->name('formulario');
Route::post('/estudiante', [App\Http\Controllers\EstudianteController::class, 'registrarEstudiante'])->name('registrarEstudiante');
Route::get('/reportes', [App\Http\Controllers\EstudianteController::class, 'mostrarReporte'])->name('reportes');
