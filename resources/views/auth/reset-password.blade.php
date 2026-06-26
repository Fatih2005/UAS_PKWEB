@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-medium ring-1 ring-brand-600/10 mb-4">
                <i class="fa-solid fa-key"></i>
                Buat Password Baru
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Reset password</h1>
            <p class="text-sm text-slate-500 mt-2">Masukkan password baru untuk akun kamu.</p>
        </div>

        <div class="glass rounded-2xl shadow-soft border border-white/60 p-8">
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <div>
                        <p class="font-medium">Terjadi kesalahan</p>
                        <p class="mt-1">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf
                @if($email)
                    <input type="hidden" name="email" value="{{ $email }}">
                @endif
                @if($token)
                    <input type="hidden" name="token" value="{{ $token }}">
                @endif

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru</label>
                    <input type="password" name="password" id="password" required
                        class="w-full rounded-xl border-slate-300 bg-white/80 shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all"
                        placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full rounded-xl border-slate-300 bg-white/80 shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all"
                        placeholder="Ulangi password baru">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-xl text-sm font-medium transition-colors">
                    Reset Password
                </button>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-200 text-center text-sm text-slate-600">
                Ingat password?
                <a href="{{ route('login') }}" class="text-brand-600 hover:text-brand-700 font-medium ml-1">Masuk</a>
            </div>
        </div>
    </div>
</div>
@endsection
