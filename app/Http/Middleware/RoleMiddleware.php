<?php

namespace App\Http\Middleware;

use Closure;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        // Jika user belum login
        if (!$request->user()) {
            // ✅ Untuk web, redirect ke login
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda harus login terlebih dahulu'
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu');
        }

        // Jika role tidak sesuai
        if ($request->user()->role != $role) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda tidak memiliki akses'
                ], 403);
            }
            return redirect()->route('home')->with('error', 'Anda tidak memiliki akses');
        }

        return $next($request);
    }
}