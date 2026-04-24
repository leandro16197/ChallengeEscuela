<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CalificacionController extends Controller
{

    public function index()
    {
        return view('estudiante.estudiante');
    }
    public function store(Request $request)
    {
        $request->validate([
            'alumno_id' => 'required|exists:users,id',
            'curso_id' => 'required|exists:cursos,id',
            'nota' => 'required|numeric|min:0|max:10',
        ]);

        $user = User::findOrFail($request->alumno_id);

        $user->cursos()->syncWithoutDetaching([
            $request->curso_id => [
                'nota' => $request->nota
            ]
        ]);

        return response()->json([
            'message' => 'Nota guardada correctamente'
        ]);
    }

    public function misNotas()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($user->role != 3) {
            abort(403);
        }


        $notas = $user->cursos()
            ->get()
            ->map(function ($curso) {
                return [
                    'curso' => $curso->name,
                    'nota'  => $curso->pivot->nota
                ];
            });

        return response()->json([
            'aaData' => $notas
        ]);
    }
}