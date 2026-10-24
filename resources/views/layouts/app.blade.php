<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Gestión Escolar') | BacarLix</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f3f6fb;
            font-family: Arial, sans-serif;
        }

        .sidebar {
            background: #14213d;
            min-height: 100vh;
            color: white;
        }

        .sidebar a {
            color: #cbd5e1;
            text-decoration: none;
            display: block;
            padding: 13px 18px;
            border-radius: 9px;
            margin-bottom: 6px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #263a60;
            color: white;
        }

        .brand {
            font-size: 23px;
            font-weight: bold;
            padding: 26px 18px;
        }

        .main-content {
            padding: 30px;
        }

        .page-title {
            font-weight: 700;
            color: #14213d;
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 15px rgba(0,0,0,.05);
        }

        .table thead th {
            background: #eef2f8;
            color: #334155;
        }

        .btn-primary {
            background: #2454a6;
            border-color: #2454a6;
        }
    </style>

    @stack('styles')
</head>

<body>
<div class="container-fluid">
    <div class="row">

        <aside class="col-md-3 col-lg-2 sidebar p-3">
            <div class="brand">
                <i class="bi bi-mortarboard-fill"></i>
                BacarLix
            </div>

            <nav>
                <a href="{{ url('/') }}"
                   class="{{ request()->is('/') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>

                <a href="{{ url('/estudiantes') }}"
                   class="{{ request()->is('estudiantes*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i>
                    Estudiantes
                </a>

                <a href="{{ url('/docentes') }}"
                   class="{{ request()->is('docentes*') ? 'active' : '' }}">
                    <i class="bi bi-person-workspace me-2"></i>
                    Docentes
                </a>

                <a href="{{ url('/asignaturas') }}"
                   class="{{ request()->is('asignaturas*') ? 'active' : '' }}">
                    <i class="bi bi-book me-2"></i>
                    Asignaturas
                </a>

                <a href="{{ url('/inscripciones') }}"
                   class="{{ request()->is('inscripciones*') ? 'active' : '' }}">
                    <i class="bi bi-journal-check me-2"></i>
                    Inscripciones
                </a>
            </nav>

            <hr class="border-secondary">

            <small class="text-white-50">
                PRO-413 · Programación III
            </small>
        </aside>

        <main class="col-md-9 col-lg-10 main-content">

            <header class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="page-title mb-1">
                        @yield('title', 'Panel principal')
                    </h2>
                    <p class="text-muted mb-0">
                        Sistema de Gestión Escolar
                    </p>
                </div>

                <span class="badge text-bg-primary p-2">
                    <i class="bi bi-database-check"></i>
                    Laravel
                </span>
            </header>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Revisa los datos ingresados:</strong>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

            <footer class="text-center text-muted mt-5">
                <small>
                    © {{ date('Y') }} BacarLix · Gestión Escolar
                </small>
            </footer>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>