<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kategori - PT. Ujug-Ujug</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter','system-ui','sans-serif'] },
                    colors: {
                        brand: { 50:'#eff6ff',100:'#dbeafe',200:'#bfdbfe',400:'#60a5fa',500:'#3b82f6',600:'#2563eb',700:'#1d4ed8',800:'#1e40af',900:'#1e3a8a' }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-feature-settings:"cv02","cv03","cv04","cv11"; }
        .grid-bg { background-image: radial-gradient(circle at 1px 1px,rgba(148,163,184,0.22) 1px,transparent 0); background-size:22px 22px; }
        .gradient-brand { background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%); }
        .btn-primary { background:linear-gradient(135deg,#2563eb 0%,#1d4ed8 100%); transition:all .2s; }
        .btn-primary:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(37,99,235,.35); }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen">
    <div class="grid-bg">
        <nav class="border-b border-slate-200/80 bg-white/70 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('tickets.index') }}" class="flex items-center gap-3 group">
                        <div class="w-9 h-9 rounded-xl gradient-brand text-white flex items-center justify-center shadow group-hover:scale-105 transition-transform">
                            <i class="fa-solid fa-ticket text-sm"></i>
                        </div>
                        <span class="text-lg font-bold text-slate-900">PT. Ujug-Ujug</span>
                    </a>
                    <span class="text-slate-300">/</span>
                    <a href="{{ route('tickets.index') }}" class="text-sm font-medium text-slate-600 hover:text-brand-600">Tickets</a>
                    <span class="text-slate-300">/</span>
                    <a href="{{ route('admin.categories.index') }}" class="text-sm font-medium text-slate-600 hover:text-brand-600">Kategori</a>
                    <span class="text-slate-300">/</span>
                    <span class="text-sm font-medium text-slate-900">Edit</span>
                </div>
                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:text-red-600 hover:bg-red-50">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="max-w-2xl">
                <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <i class="fa-solid fa-pen"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-slate-900">Edit Kategori</h1>
                            <p class="text-sm text-slate-500">Perbarui detail kategori yang sedang dipakai oleh tiket.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Nama kategori</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required
                                    class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all">
                                @error('name') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="slug" class="block text-sm font-medium text-slate-700 mb-1.5">Slug</label>
                                <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}"
                                    class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all">
                                @error('slug') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all">{{ old('description', $category->description) }}</textarea>
                            @error('description') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="sla_hours" class="block text-sm font-medium text-slate-700 mb-1.5">SLA (jam)</label>
                            <input type="number" name="sla_hours" id="sla_hours" value="{{ old('sla_hours', $category->sla_hours) }}" min="1"
                                class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all">
                            @error('sla_hours') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-2">
                            <a href="{{ route('admin.categories.index') }}" class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100">Batal</a>
                            <button type="submit" class="btn-primary text-white px-5 py-2.5 rounded-xl text-sm font-medium">Perbarui Kategori</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
