@extends('layouts.app')

@section('title', 'Lupa Password')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-medium ring-1 ring-brand-600/10 mb-4">
                <i class="fa-solid fa-envelope-circle-check"></i>
                Reset Password
            </div>
            <h1 class="text-2xl font-bold text-slate-900">Lupa password?</h1>
            <p class="text-sm text-slate-500 mt-2">Masukkan email kamu, kami akan kirim link untuk reset password.</p>
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

            @if(session('status'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                    <i class="fa-solid fa-check-circle mt-0.5"></i>
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                    <input type="email" name="email" id="email" required autofocus
                        class="w-full rounded-xl border-slate-300 bg-white/80 shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all"
                        placeholder="user@example.com">
                </div>
                <button type="submit" class="w-full gradient-brand text-white py-2.5 rounded-xl text-sm font-medium hover:shadow-lg hover:-translate-y-0.5 transition-all">
                    Kirim Link Reset
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
