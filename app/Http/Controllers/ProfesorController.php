<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProfesorController extends Controller
{
    public function index()
    {
        $profesorId = Auth::id();

        $cursos = Curso::where('teacher_id', $profesorId)->get();

        return view('profesor.profesor', compact('cursos'));
    }

    public function alumnos(Request $request)
    {
        $profesorId = Auth::id();

        $query = DB::table('curso_user')
            ->join('cursos', 'cursos.id', '=', 'curso_user.curso_id')
            ->join('users', 'users.id', '=', 'curso_user.user_id')
            ->where('cursos.teacher_id', $profesorId)
            ->select(
                'users.id',
                'users.name',
                'curso_user.nota',
                'cursos.id as curso_id',
                'cursos.name as curso'
            );

        if ($request->filled('curso_id')) {
            $query->where('cursos.id', $request->curso_id);
        }

        return response()->json([
            'aaData' => $query->get()
        ]);
    }

    public function actualizarNota(Request $request)
    {
        $profesorId = Auth::id();
        $curso = Curso::where('id', $request->curso_id)
            ->where('teacher_id', $profesorId)
            ->firstOrFail();

        DB::table('curso_user')
            ->where('curso_id', $curso->id)
            ->where('user_id', $request->user_id)
            ->update([
                'nota' => $request->nota
            ]);

        return response()->json(['ok' => true]);
    }
}