<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form register
    public function showRegister()
    {
        return view('register');
    }

    // Simpan data register
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'no_hp' => 'required',
            'password' => 'required|min:6|confirmed', // ✅ Tambah confirmed
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 0
        ]);

        return redirect()->route('login')->with('success', 'Register berhasil, silakan login.');
    }

    // Tampilkan form login
    public function showLogin()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role == 1) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    // Logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    // ✅ FITUR LUPA PASSWORD - Tampilkan form
    public function showForgotPassword()
    {
        return view('forgot-password');
    }

    // ✅ Kirim link reset password ke email
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Generate token
        $token = Str::random(64);

        // Simpan ke database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($token),
                'created_at' => now()
            ]
        );

        // ✅ Kirim link reset (untuk development, tampilkan di session)
        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);
        
        return back()->with('success', 'Link reset password: ' . $resetLink);
    }

    // ✅ Tampilkan form reset password
    public function showResetPassword(Request $request)
    {
        return view('reset-password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    // ✅ Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ], [
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Cek token
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$resetRecord || !Hash::check($request->token, $resetRecord->token)) {
            return back()->with('error', 'Token tidak valid atau sudah kedaluwarsa.');
        }

        // Update password
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Hapus token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login.');
    }
}