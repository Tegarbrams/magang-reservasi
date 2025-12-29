<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, ...$roles)
    {
        // Jika user belum login
        if (!$request->user()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda harus login terlebih dahulu'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }

        // Jika role tidak sesuai (support multiple roles)
        if (!in_array($request->user()->role, $roles)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses'
                ], 403);
            }
            
            // Redirect based on user role
            if ($request->user()->role == 2) {
                return redirect()->route('superadmin.dashboard')->with('error', 'Anda tidak memiliki akses');
            } elseif ($request->user()->role == 1) {
                return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses');
            }
            
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses');
        }

        return $next($request);
    }
}