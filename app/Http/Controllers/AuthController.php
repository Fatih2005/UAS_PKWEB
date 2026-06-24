<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Kredensial tidak sesuai']);
        }

        $request->session()->regenerate();

        Auth::login($user);

        return redirect('/tickets');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $request->session()->regenerate();

        Auth::login($user);

        return redirect('/tickets')->with('status', 'Registrasi berhasil');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('status', 'Kamu sudah logout');
    }

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan']);
        }

        $token = \Illuminate\Support\Str::random(60);

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now()->addMinutes(60),
            ]
        );

        $encodedEmail = rtrim(strtr(base64_encode($request->email), '+/', '-_'), '=');

        return redirect('/reset-password/'.$encodedEmail)
            ->with('status', 'Verifikasi email berhasil, silakan buat password baru');
    }

    public function showResetPasswordForm($encodedEmail)
    {
        $email = base64_decode(strtr($encodedEmail, '-_', '+/'));

        if (! $email || ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            abort(404);
        }

        $tokenRow = \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $email)->latest('created_at')->first();
        $token = $tokenRow?->token ?? null;

        return view('auth.reset-password', compact('email', 'token'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $tokenRow = \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (! $tokenRow || $request->token !== $tokenRow->token) {
            return back()->withErrors(['email' => 'Token tidak valid atau kadaluarsa']);
        }

        $user = \App\Models\User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Akun tidak ditemukan']);
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();

        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect('/login')->with('status', 'Password berhasil direset, silakan login');
    }
}
