<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    public function handle($request, Closure $next, $rol)
    {
        $user = Auth::user();

        $userRoleName = ($user && $user->role_relation) ? $user->role_relation->name : null;

        $userRole = trim(strtolower($userRoleName));
        $requiredRole = trim(strtolower($rol));

        if (!$user || $userRole !== $requiredRole) {
            abort(403, "No autorizado. Tu rol actual no coincide con el permiso requerido.");
        }

        return $next($request);
    }
}