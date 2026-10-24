@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<div class="row g-4 mb-4">

    @php
        $tarjetas = [
            [
                'titulo' => 'Estudiantes',
                'cantidad' => $totalEstudiantes ?? 0,
                'icono' => 'bi-people-fill',
                'color' => 'primary'
            ],
            [
                'titulo' => 'Docentes',
                'cantidad' => $totalDocentes ?? 0,
                'icono' => 'bi-person-workspace',
                'color' => 'success'
            ],
            [
                'titulo' => 'Asignaturas',
                'cantidad' => $totalAsignaturas ?? 0,
                'icono' => 'bi-book-fill',
                'color' => 'warning'
            ],
            [
                'titulo' => 'Inscripciones',
                'cantidad' => $totalInscripciones ?? 0,
                'icono' => 'bi-journal-check',
                'color' => 'info'
            ],
        ];
    @endphp

    @foreach($tarjetas as $tarjeta)
        <div class="col-md-6 col-xl-3">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">
                            {{ $tarjeta['titulo'] }}
                        </p>

                        <h2 class="fw-bold mb-0">
                            {{ $tarjeta['cantidad'] }}
                        </h2>
                    </div>

                    <i class="bi {{ $tarjeta['icono'] }}
                              text-{{ $tarjeta['color'] }}
                              fs-1"></i>
                </div>
            </div>
        </div>
    @endforeach

</div>

<div class="row g-4">

    <div class="col-lg-8">
        <div class="card p-4">
            <h5 class="fw-bold">Bienvenido al sistema</h5>

            <p class="text-muted">
                Administra estudiantes, docentes, asignaturas
                e inscripciones desde un mismo lugar.
            </p>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ url('/estudiantes') }}"
                   class="btn btn-primary">
                    Ver estudiantes
                </a>

                <a href="{{ url('/docentes') }}"
                   class="btn btn-outline-primary">
                    Ver docentes
                </a>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card p-4">
            <h5 class="fw-bold">Arquitectura</h5>

            <p class="mb-2">
                <i class="bi bi-server text-primary"></i>
                MySQL del grupo
            </p>

            <p class="mb-0">
                <i class="bi bi-server text-success"></i>
                MySQL institucional
            </p>

            <small class="text-muted mt-3">
                El estado real de las conexiones se verifica
                desde el backend.
            </small>
        </div>
    </div>

</div>

@endsection