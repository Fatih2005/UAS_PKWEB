<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PT. Ujug-Ujug</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-feature-settings: "cv02", "cv03", "cv04", "cv11"; }
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); }
        .grid-bg {
            background-image: radial-gradient(circle at 1px 1px, rgba(148,163,184,0.25) 1px, transparent 0);
            background-size: 24px 24px;
        }
        .gradient-brand {
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 60%, #1e3a8a 100%);
        }
        .input-group input:focus ~ label,
        .input-group input:not(:placeholder-shown) ~ label {
            transform: translateY(-1.4rem) scale(0.85);
            color: #2563eb;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col">
    <div class="flex-1 grid-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl gradient-brand text-white flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-ticket text-sm"></i>
                    </div>
                    <span class="text-lg font-bold text-slate-900">PT. Ujug-Ujug</span>
                </a>
            </div>

            <div class="mt-20 mb-10 text-center">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 text-brand-700 text-xs font-medium ring-1 ring-brand-600/10 mb-4">
                    <i class="fa-solid fa-shield-halved"></i>
                    Secure Ticketing System
                </div>
                <h1 class="text-3xl font-bold text-slate-900">Selamat datang kembali</h1>
                <p class="text-slate-500 mt-2">Masuk untuk mengelola tiket tim kamu</p>
            </div>

            <div class="max-w-md mx-auto">
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

                    <form action="/login" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                            <input type="email" name="email" id="email" required autofocus
                                class="w-full rounded-xl border-slate-300 bg-white/80 shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all"
                                placeholder="user@example.com">
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                            <input type="password" name="password" id="password" required
                                class="w-full rounded-xl border-slate-300 bg-white/80 shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all"
                                placeholder="••••••••">
                        </div>
                        <button type="submit" class="w-full gradient-brand text-white py-2.5 rounded-xl text-sm font-medium hover:shadow-lg hover:-translate-y-0.5 transition-all">
                            Masuk
                        </button>
                    </form>

                    <div class="mt-6 pt-6 border-t border-slate-200 text-center text-sm text-slate-600">
                        <a href="{{ route('password.request') }}" class="text-brand-600 hover:text-brand-700 font-medium">Lupa password?</a>
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-200 text-center text-sm text-slate-600">
                        Belum punya akun?
                        <a href="/register" class="text-brand-600 hover:text-brand-700 font-medium ml-1">Daftar sekarang</a>
                    </div>

                    <div class="mt-6 pt-6 border-t border-slate-200 text-center text-sm text-slate-600">
                        <a href="{{ route('password.request') }}" class="text-brand-600 hover:text-brand-700 font-medium">Lupa password?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
