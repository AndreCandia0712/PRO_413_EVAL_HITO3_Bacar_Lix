@extends('layouts.app')

@section('title', 'Inscripciones')

@section('content')

<div class="card p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Inscripciones</h5>

        <span class="badge text-bg-info">
            Gestión académica
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Estudiante</th>
                    <th>Asignatura</th>
                    <th>Fecha</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse(($inscripciones ?? []) as $inscripcion)
                    <tr>
                        <td>{{ $inscripcion->id }}</td>

                        <td>
                            {{ $inscripcion->estudiante?->nombres ?? 'Sin estudiante' }}
                            {{ $inscripcion->estudiante?->apellidos ?? '' }}
                        </td>

                        <td>
                            {{ $inscripcion->asignatura?->nombre ?? 'Sin asignatura' }}
                        </td>

                        <td>{{ $inscripcion->fecha_inscripcion }}</td>

                        <td>
                            <span class="badge text-bg-success">
                                {{ $inscripcion->estado }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            No hay inscripciones registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection