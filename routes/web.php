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

