<?php

namespace App\Http\Controllers;

use App\Models\Role; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.roles');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'display_name' => 'required|string|max:255',
        ]);

        $rol = Role::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Rol creado correctamente',
            'data' => $rol
        ]);
    }


    public function getData(Request $request)
    {
        try {
            $roles = Role::all();

            $data = $roles->map(function ($role) {
                return [
                    'id'           => $role->id,
                    'name'         => $role->name,
                    'display_name' => $role->display_name,
                ];
            });

            return response()->json([
                "aaData" => $data
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $rol = Role::findOrFail($id);

        return response()->json($rol);
    }

    public function update(Request $request, $id)
    {
        $rol = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $rol->id,
            'display_name' => 'required|string|max:255',
        ]);

        $rol->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
        ]);

        return response()->json([
            'success' => true,
            'msg' => 'Rol actualizado correctamente',
            'data' => $rol
        ]);
    }
    public function destroy($id)
    {
        $rol = Role::findOrFail($id);

        $user = Auth::user();
        if ($user->role == $rol->id) {
            return response()->json([
                'success' => false,
                'msg' => 'No podés eliminar tu propio rol'
            ], 403);
        }

        $rol->delete();

        return response()->json([
            'success' => true,
            'msg' => 'Rol eliminado correctamente'
        ]);
    }
    
}