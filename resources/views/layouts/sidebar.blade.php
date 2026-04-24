@php
    $user = auth()->user();
@endphp

<aside class="sidebar">

    <div class="sidebar-logo">
        <span>SCHOOL</span>APP
    </div>

    <nav class="space-y-4">

        <a href="{{ route('dashboard') }}" class="sidebar-link">
            Dashboard
        </a>

        @if ($user->hasRole('admin'))
            <div class="sidebar-section">
                Administración
            </div>

            <a href="{{ route('admin.cursos.index') }}" class="sidebar-link">
                Gestionar Cursos
            </a>

            <a href="{{ route('admin.roles.index') }}" class="sidebar-link">
                Usuarios y Roles
            </a>
        @endif


        @if ($user->hasRole('teacher'))
            <div class="sidebar-section">
                Docente
            </div>

            <a href="{{ route('teacher.cursos.index') }}" class="sidebar-link">
                Mis Cursos
            </a>
        @endif

        @if ($user->hasRole('student'))
            <div class="sidebar-section">
                Alumno
            </div>

            <a href="{{ route('estudiante.index') }}" class="sidebar-link">
                Mis Notas
            </a>
        @endif

    </nav>
</aside>
