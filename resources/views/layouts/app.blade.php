<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PT. Ujug-Ujug Ticketing')</title>
    <meta name="description" content="Sistem Ticketing PT. Ujug-Ujug">
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
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    },
                    boxShadow: {
                        'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                        'glow': '0 0 20px rgba(59, 130, 246, 0.15)',
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.2s ease-out',
                        'slide-up': 'slideUp 0.3s ease-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                    },
                }
            }
        }
    </script>
    <style>
        body { font-feature-settings: "cv02", "cv03", "cv04", "cv11"; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); }
        .card-hover { transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-hover:hover { transform: translateY(-1px); box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1); }
        .btn-primary { background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); transition: all 0.2s; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37, 99, 235, 0.35); }
        .priority-critical { border-left: 3px solid #ef4444; }
        .priority-high { border-left: 3px solid #f97316; }
        .priority-medium { border-left: 3px solid #eab308; }
        .priority-low { border-left: 3px solid #94a3b8; }
    </style>
    @stack('head')
</head>

<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">
    <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-brand-600 text-white flex items-center justify-center shadow-glow">
                        <i class="fa-solid fa-ticket text-sm"></i>
                    </div>
                    <div>
                        <span class="text-lg font-bold text-slate-900 leading-none">PT. Ujug-Ujug</span>
                        <span class="text-[10px] font-medium text-slate-400 uppercase tracking-wider block">Ticketing System</span>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <a href="{{ route('tickets.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-brand-600 hover:bg-brand-50 transition-colors">
                        <i class="fa-solid fa-ticket mr-1.5"></i>Tickets
                    </a>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-brand-600 hover:bg-brand-50 transition-colors">
                                <i class="fa-solid fa-layer-group mr-1.5"></i>Kategori
                            </a>
                        @endif
                        <div class="h-5 w-px bg-slate-200 mx-2"></div>
                        <span class="text-xs text-slate-500 mr-1">{{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-red-600 hover:bg-red-50 transition-colors">
                                <i class="fa-solid fa-arrow-right-from-bracket mr-1.5"></i>Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 animate-fade-in">
        @if(session('status'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i><span>{{ session('status') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i><span>{{ session('error') }}</span>
            </div>
        @endif
        @yield('content')
    </main>
    @stack('scripts')
</body>
</html>
