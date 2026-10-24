@extends('layouts.app')

@section('title', 'Estudiantes')

@section('content')

<div class="card p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Listado de estudiantes</h5>

        <a href="{{ url('/estudiantes/crear') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Nuevo estudiante
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Correo</th>
                    <th>Fecha de nacimiento</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse(($estudiantes ?? []) as $estudiante)
                    <tr>
                        <td>{{ $estudiante->id }}</td>
                        <td>{{ $estudiante->nombres }}</td>
                        <td>{{ $estudiante->apellidos }}</td>
                        <td>{{ $estudiante->correo }}</td>
                        <td>{{ $estudiante->fecha_nacimiento }}</td>

                        <td>
                            <a href="{{ url('/estudiantes/'.$estudiante->id.'/editar') }}"
                               class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                                Editar
                            </a>

                            <form action="{{ url('/estudiantes/'.$estudiante->id) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Eliminar estudiante?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No hay estudiantes registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection