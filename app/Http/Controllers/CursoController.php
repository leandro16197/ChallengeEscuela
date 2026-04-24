<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;

class CursoController extends Controller
{   
    public function index()
    {
        $cursos = Curso::with('profesor', 'alumnos')->get();
        $profesores = User::whereHas('role_relation', function($query) {
                $query->where('name', 'teacher');
            })->get();
        $todosLosAlumnos = User::whereHas('role_relation', function($query) {
                $query->where('name', 'student');
            })->get();

        return view('cursos.curso', compact('cursos', 'profesores', 'todosLosAlumnos'));
    }

    public function create()
    {
        $profesores = User::where('role', 'teacher')->get(); 
        return view('cursos.create', compact('profesores'));
    }

    public function getData(Request $request)
    {
        try {
            $cursos = Curso::with(['profesor', 'alumnos'])->get();

            $data = $cursos->map(function ($curso) {
                return [
                    'id'         => $curso->id,
                    'name'       => $curso->name ?? $curso->nombre,
                    'teacher_id' => $curso->teacher_id,
                    'profesor'   => $curso->profesor ? [
                        'name' => $curso->profesor->name
                    ] : null,
                    'alumnos'    => $curso->alumnos->map(function($alumno) {
                        return ['id' => $alumno->id];
                    })->toArray(),
                ];
            });

            return response()->json([
                "sEcho"                => intval($request->get('sEcho')),
                "iTotalRecords"        => count($data),
                "iTotalDisplayRecords" => count($data),
                "aaData"               => $data
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function asignarAlumnos(Request $request, $id)
    {
        try {
            $curso = Curso::findOrFail($id); 
            
            $curso->alumnos()->sync($request->input('alumnos', []));

            return response()->json([
                'success' => true,
                'message' => 'Alumnos actualizados correctamente'
            ]); 
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud'
            ], 500);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'profesor_id' => 'required|exists:users,id' 
        ]);

        $curso = Curso::create([
            'name'       => $request->nombre,    
            'teacher_id' => $request->profesor_id, 
        ]);

        $curso->load('profesor');

        return response()->json([
            'success' => true,
            'curso' => [
                'id' => $curso->id,
                'nombre' => $curso->name,
                'teacher_id' => $curso->teacher_id,
                'profesor' => $curso->profesor
            ]
        ]);
    }

    public function edit($id)
    {
        $curso = Curso::findOrFail($id);
        $profesores = User::where('role', 'profesor')->get();

        return view('cursos.edit', compact('curso', 'profesores'));
    }

    public function update(Request $request, $id)
    {
   
        $curso = Curso::findOrFail($id);
   
        $request->validate([
            'nombre' => 'required|string|max:255',
            'profesor_id' => 'nullable|exists:users,id',
        ]);

       $curso->update([
            'name' => $request->nombre,
            'teacher_id' => $request->profesor_id 
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'curso' => $curso->refresh()->load('profesor') 
            ]);
        }

        return redirect()->route('admin.cursos.index')
            ->with('success', 'Curso actualizado');
    }

    public function destroy($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'id' => $id,
                'message' => 'Curso eliminado'
            ]);
        }
        return redirect()->back()->with('success', 'Curso eliminado');
    }
}
