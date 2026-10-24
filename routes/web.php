<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\EstadoSistemaController;

Route::get('/estado-sistema', [
    EstadoSistemaController::class,
    'index'
])->name('estado.sistema');

use App\Http\Controllers\DocenteController;

Route::get('/docentes', [DocenteController::class, 'index'])
    ->name('docentes.index');

Route::get('/docentes/crear', [DocenteController::class, 'create'])
    ->name('docentes.create');

Route::post('/docentes', [DocenteController::class, 'store'])
    ->name('docentes.store');

Route::get('/docentes/{id}/editar', [DocenteController::class, 'edit'])
    ->name('docentes.edit');

Route::put('/docentes/{id}', [DocenteController::class, 'update'])
    ->name('docentes.update');

Route::delete('/docentes/{id}', [DocenteController::class, 'destroy'])
    ->name('docentes.destroy');


