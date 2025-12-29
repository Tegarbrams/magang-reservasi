<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    // ================================
    // WEB VIEWS (Untuk Form HTML)
    // ================================

    /**
     * Tampilkan form register
     */
    public function showRegister()
    {
        return view('register');
    }

    /**
     * Tampilkan form login
     */
    public function showLogin()
    {
        return view('login');
    }

    /**
     * Handle web login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            if (auth()->user()->role == 2) {
                return redirect()->route('admin.dashboard');
            } elseif (auth()->user()->role == 1) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }

        return back()->with('error', 'Email atau password salah');
    }

    /**
     * Handle web register
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'no_hp' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 0
        ]);

        auth()->login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil');
    }

    /**
     * Tampilkan form forgot password
     */
    public function showForgotPassword()
    {
        return view('forgot-password');
    }

    /**
     * Tampilkan form reset password
     */
    public function showResetPassword($token, Request $request)
    {
        return view('reset-password', [
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    /**
     * Handle send reset link (web)
     */
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan');
        }

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $link = url('/reset-password/' . $token . '?email=' . $request->email);

        // Dalam production, kirim email di sini
        // Untuk development, tampilkan link
        return back()->with('success', 'Link reset password: ' . $link);
    }

    /**
     * Handle reset password (web)
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return back()->with('error', 'Token tidak valid atau kedaluwarsa');
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil direset');
    }

    // ================================
    // API ENDPOINTS (JSON Response)
    // ================================

    /**
     * API Register
     */
    public function apiRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'no_hp' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 0 // default user
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Register berhasil',
            'user' => $user,
            'token' => $token
        ], 201);
    }

    /**
     * API Login
     */
    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email atau password salah'
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'role' => $user->role,
            'user' => $user,
            'token' => $token
        ]);
    }

    /**
     * API Logout
     */
    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * API Send Reset Link
     */
    public function apiSendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        $link = url('/reset-password/' . $token . '?email=' . $request->email);

        return response()->json([
            'status' => 'success',
            'message' => 'Link reset password dibuat',
            'reset_link' => $link
        ]);
    }

    /**
     * API Reset Password
     */
    public function apiResetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$record || !Hash::check($request->token, $record->token)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid atau kedaluwarsa'
            ], 400);
        }

        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Password berhasil direset'
        ]);
    }
}
