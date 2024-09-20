<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  array  $roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login'); // Redirect jika pengguna tidak terautentikasi
        }

        if (!in_array($user->role, $roles)) {
            return response()->json(['message' => 'Access denied'], 403); // Unauthorized
        }

        return $next($request);
    }
}
