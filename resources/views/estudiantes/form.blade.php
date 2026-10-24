@extends('layouts.app')

@section('title', isset($estudiante) ? 'Editar estudiante' : 'Nuevo estudiante')

@section('content')

<div class="card p-4">

    <form
        action="{{ isset($estudiante)
            ? url('/estudiantes/'.$estudiante->id)
            : url('/estudiantes') }}"
        method="POST"
    >
        @csrf

        @if(isset($estudiante))
            @method('PUT')
        @endif

        <div class="row g-3">

            <div class="col-md-6">
                <label class="form-label">Nombres</label>

                <input
                    type="text"
                    name="nombres"
                    class="form-control"
                    value="{{ old('nombres', $estudiante->nombres ?? '') }}"
                    required
                    maxlength="100"
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Apellidos</label>

                <input
                    type="text"
                    name="apellidos"
                    class="form-control"
                    value="{{ old('apellidos', $estudiante->apellidos ?? '') }}"
                    required
                    maxlength="100"
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Correo electrónico</label>

                <input
                    type="email"
                    name="correo"
                    class="form-control"
                    value="{{ old('correo', $estudiante->correo ?? '') }}"
                    required
                >
            </div>

            <div class="col-md-6">
                <label class="form-label">Fecha de nacimiento</label>

                <input
                    type="date"
                    name="fecha_nacimiento"
                    class="form-control"
                    value="{{ old('fecha_nacimiento', $estudiante->fecha_nacimiento ?? '') }}"
                >
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i>
                Guardar
            </button>

            <a href="{{ url('/estudiantes') }}"
               class="btn btn-secondary">
                Cancelar
            </a>
        </div>
    </form>

</div>

@endsection