@extends('layouts.app')

@section('title', isset($docente) ? 'Editar docente' : 'Nuevo docente')

@section('content')

<div class="card p-4">

    <form
        action="{{ isset($docente)
            ? url('/docentes/'.$docente->id)
            : url('/docentes') }}"
        method="POST"
    >
        @csrf

        @if(isset($docente))
            @method('PUT')
        @endif

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Nombres</label>

                <input
                    type="text"
                    name="nombres"
                    class="form-control"
                    value="{{ old('nombres', $docente->nombres ?? '') }}"
                    required
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Apellidos</label>

                <input
                    type="text"
                    name="apellidos"
                    class="form-control"
                    value="{{ old('apellidos', $docente->apellidos ?? '') }}"
                    required
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Especialidad</label>

                <input
                    type="text"
                    name="especialidad"
                    class="form-control"
                    value="{{ old('especialidad', $docente->especialidad ?? '') }}"
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Correo electrónico</label>

                <input
                    type="email"
                    name="correo"
                    class="form-control"
                    value="{{ old('correo', $docente->correo ?? '') }}"
                >
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Guardar docente
            </button>

            <a href="{{ url('/docentes') }}"
               class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>

</div>

@endsection