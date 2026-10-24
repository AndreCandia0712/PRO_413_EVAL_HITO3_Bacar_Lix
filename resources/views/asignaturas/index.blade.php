@extends('layouts.app')

@section('title', 'Asignaturas')

@section('content')

<div class="card p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="fw-bold mb-0">Asignaturas registradas</h5>
        <span class="badge text-bg-primary">
            Base MySQL del grupo
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Asignatura</th>
                    <th>Créditos</th>
                </tr>
            </thead>

            <tbody>
                @forelse(($asignaturas ?? []) as $asignatura)
                    <tr>
                        <td>{{ $asignatura->id }}</td>
                        <td>{{ $asignatura->codigo }}</td>
                        <td>{{ $asignatura->nombre }}</td>
                        <td>{{ $asignatura->creditos }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            No hay asignaturas registradas.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection