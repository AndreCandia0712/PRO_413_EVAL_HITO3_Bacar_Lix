<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class EstadoSistemaController extends Controller
{
    public function index(): JsonResponse
    {
        $resultado = [];

        foreach ([
            'mysql' => 'Base de Pablo',
            'mysql_docente' => 'Base institucional',
        ] as $conexion => $nombre) {
            try {
                DB::connection($conexion)->select('SELECT 1');

                $resultado[$conexion] = [
                    'nombre' => $nombre,
                    'estado' => 'Conectado',
                ];
            } catch (Throwable $e) {
                report($e);

                $resultado[$conexion] = [
                    'nombre' => $nombre,
                    'estado' => 'Sin conexión',
                ];
            }
        }

        return response()->json($resultado);
    }
}
