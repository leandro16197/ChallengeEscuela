<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {   
        if ($request->ajax()) {
            $usuarios = User::with('role_relation')->get();

            return response()->json([
                'aaData' => $usuarios
            ]);
        }

        return view('roles.roles'); 
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
            'role' => 'required' 
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Error al crear usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {  
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:4',
            'role' => 'required'
        ]);

        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ];
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $user->update($data);

            return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return response()->json(['success' => true, 'message' => 'Usuario eliminado']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo eliminar el usuario'
            ], 500);
        }
    }
}
