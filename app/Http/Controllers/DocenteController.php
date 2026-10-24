<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Docente;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Database\QueryException;
use Throwable;

class DocenteController extends Controller
{
    // READ: listar docentes
    public function index(): View
    {
        $docentes = Docente::orderBy('id', 'desc')->get();

        return view('docentes.index', compact('docentes'));
    }

    // CREATE: mostrar formulario
    public function create(): View
    {
        return view('docentes.form');
    }

    // CREATE: guardar docente
    public function store(Request $request): RedirectResponse
    {
        $datos = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'correo' => 'nullable|email|max:150',
        ]);

        try {
            Docente::create($datos);

            return redirect('/docentes')
                ->with('success', 'Docente registrado correctamente.');
        } catch (QueryException $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'No se pudo registrar el docente. Verifica que el correo no esté duplicado.',
                ]);
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'Ocurrió un error al registrar el docente.',
                ]);
        }
    }

    // UPDATE: mostrar formulario
    public function edit(int $id): View
    {
        $docente = Docente::findOrFail($id);

        return view('docentes.form', compact('docente'));
    }

    // UPDATE: actualizar docente
    public function update(Request $request, int $id): RedirectResponse
    {
        $docente = Docente::findOrFail($id);

        $datos = $request->validate([
            'nombres' => 'required|string|max:100',
            'apellidos' => 'required|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'correo' => 'nullable|email|max:150',
        ]);

        try {
            $docente->update($datos);

            return redirect('/docentes')
                ->with('success', 'Docente actualizado correctamente.');
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withInput()
                ->withErrors([
                    'error' => 'No se pudo actualizar el docente.',
                ]);
        }
    }

    // DELETE: eliminar docente
    public function destroy(int $id): RedirectResponse
    {
        try {
            $docente = Docente::findOrFail($id);
            $docente->delete();

            return redirect('/docentes')
                ->with('success', 'Docente eliminado correctamente.');
        } catch (Throwable $e) {
            report($e);

            return back()
                ->withErrors([
                    'error' => 'No se pudo eliminar el docente. Puede tener asignaciones relacionadas.',
                ]);
        }
    }
}
