<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InvalidateSessions
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            // Obtener todas las sesiones activas del usuario
            $sessions = DB::table('sessions')
                ->where('user_id', $user->id)
                ->pluck('id');

            // Invalidar todas las sesiones excepto la actual
            DB::table('sessions')
                ->whereIn('id', $sessions)
                ->delete();
        }

        return $next($request);
    }
}
