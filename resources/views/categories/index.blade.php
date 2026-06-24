<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kategori Tiket - PT. Ujug-Ujug</title>
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
        .glass { background:rgba(255,255,255,0.9); backdrop-filter:blur(12px); }
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
                <a href="{{ route('tickets.index') }}" class="flex items-center gap-3 group">
                    <div class="w-9 h-9 rounded-xl gradient-brand text-white flex items-center justify-center shadow group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-ticket text-sm"></i>
                    </div>
                    <span class="text-lg font-bold text-slate-900">PT. Ujug-Ujug</span>
                </a>
                <div class="flex items-center gap-1">
                    <a href="{{ route('tickets.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:text-brand-600 hover:bg-brand-50">Tickets</a>
                    @auth
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:text-brand-600 hover:bg-brand-50">Kategori</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="px-3 py-2 rounded-lg text-sm font-medium text-slate-700 hover:text-red-600 hover:bg-red-50">Logout</button>
                        </form>
                    @endauth
                </div>
            </div>
        </nav>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            @if(session('status'))
                <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-check mt-0.5"></i>
                    <div>{{ session('status') }}</div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-xl font-bold text-slate-900">Kategori Tiket</h1>
                    <p class="text-sm text-slate-500">KelOLA kategori yang digunakan untuk mengelompokkan tiket masuk.</p>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="btn-primary text-white px-4 py-2.5 rounded-xl text-sm font-medium">
                    <i class="fa-solid fa-plus mr-2"></i>Buat Kategori
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-soft border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-slate-50/80 border-b border-slate-100">
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Slug</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">SLA (jam)</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($categories as $category)
                                <tr class="hover:bg-slate-50/70 transition-colors">
                                    <td class="px-6 py-3 text-sm font-medium text-slate-900">{{ $category->name }}</td>
                                    <td class="px-6 py-3 text-sm text-slate-500 font-mono">{{ $category->slug }}</td>
                                    <td class="px-6 py-3 text-sm text-slate-600">{{ $category->sla_hours }} jam</td>
                                    <td class="px-6 py-3 text-right text-sm">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-600 hover:text-brand-600 hover:bg-brand-50 transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline" id="deleteCategoryForm-{{ $category->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="openDeleteCategoryModal('{{ $category->id }}', '{{ $category->name }}')" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-600 hover:text-red-600 hover:bg-red-50 transition-colors">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-14 h-14 rounded-full bg-slate-100 flex items-center justify-center mb-3">
                                                <i class="fa-solid fa-layer-group text-xl text-slate-400"></i>
                                            </div>
                                            <p class="text-sm font-medium text-slate-700">Belum ada kategori</p>
                                            <p class="text-xs text-slate-500 mt-1">Tambahkan kategori pertama untuk mulai mengelompokkan tiket.</p>
                                            <a href="{{ route('admin.categories.create') }}" class="mt-4 btn-primary text-white px-4 py-2 rounded-xl text-sm font-medium">
                                                Buat Kategori
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <div id="confirmationModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity">
        <div class="bg-[#1a1625] border border-white/10 rounded-2xl shadow-2xl p-6 w-full max-w-sm mx-4">
            <p id="modalMessage" class="text-white text-sm leading-relaxed">Apakah kamu yakin ingin menghapus item ini? Aksi ini tidak dapat dibatalkan.</p>
            <div class="mt-5 flex justify-end gap-2">
                <button type="button" onclick="closeModal()" class="px-4 py-2 rounded-full text-sm font-medium text-white bg-[#7c3aed] hover:bg-[#6d28d9] transition-colors">Batal</button>
                <button type="button" id="modalConfirmButton" class="px-4 py-2 rounded-full text-sm font-medium text-white bg-red-500 hover:bg-red-600 transition-colors">Ya, Hapus</button>
            </div>
        </div>
    </div>

    <script>
        function openDeleteCategoryModal(id, name) {
            const modal = document.getElementById('confirmationModal');
            const message = document.getElementById('modalMessage');
            const form = document.getElementById('deleteCategoryForm-' + id);
            if (!form) return;
            message.textContent = 'Hapus kategori "' + name + '"? Tiket yang menggunakannya tidak akan memiliki kategori.';
            document.getElementById('modalConfirmButton').onclick = () => form.submit();
            modal.classList.remove('hidden');
        }
        function closeModal() {
            const modal = document.getElementById('confirmationModal');
            if (modal) modal.classList.add('hidden');
        }
    </script>
</body>
</html>
