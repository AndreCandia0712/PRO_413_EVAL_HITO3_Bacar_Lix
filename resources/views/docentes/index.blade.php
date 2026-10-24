@extends('layouts.app')

@section('title', 'Docentes')

@section('content')

<div class="card p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Listado de docentes</h5>

        <a href="{{ url('/docentes/crear') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Nuevo docente
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Especialidad</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse(($docentes ?? []) as $docente)
                    <tr>
                        <td>{{ $docente->id }}</td>
                        <td>{{ $docente->nombres }}</td>
                        <td>{{ $docente->apellidos }}</td>
                        <td>{{ $docente->especialidad }}</td>
                        <td>{{ $docente->correo }}</td>

                        <td>
                            <a href="{{ url('/docentes/'.$docente->id.'/editar') }}"
                               class="btn btn-sm btn-outline-primary">
                                Editar
                            </a>

                            <form
                                action="{{ url('/docentes/'.$docente->id) }}"
                                method="POST"
                                class="d-inline"
                                onsubmit="return confirm('¿Eliminar docente?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-outline-danger">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            No hay docentes registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection