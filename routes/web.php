<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\ProfesorController;
use App\Http\Controllers\RoleController;

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'rol:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('cursos/data', [CursoController::class, 'getData'])->name('cursos.data');
    Route::post('cursos/{curso}/alumnos', [CursoController::class, 'asignarAlumnos'])->name('cursos.alumnos.store');
    Route::resource('cursos', CursoController::class);
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('roles/data', [RoleController::class, 'getData'])->name('roles.data');
    Route::resource('roles', RoleController::class);
    Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy');
});

Route::middleware(['auth', 'rol:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/cursos', [ProfesorController::class, 'index'])->name('cursos.index');
    Route::get('/alumnos', [ProfesorController::class, 'alumnos'])->name('alumnos');
    Route::post('/alumnos/nota', [ProfesorController::class, 'actualizarNota'])->name('alumnos.nota');
});

Route::middleware(['auth', 'rol:student'])->group(function () {
    Route::get('/estudiante', [CalificacionController::class, 'index'])->name('estudiante.index');
    Route::get('/mis-notas', [CalificacionController::class, 'misNotas'])->name('student.notas');
});

require __DIR__ . '/auth.php';
