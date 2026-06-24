<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tiket #{{ $ticket->id }} - PT. Ujug-Ujug</title>
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
        .drop-zone { transition: all 0.2s ease; }
        .drop-zone.drag-over { border-color: #2563eb !important; background: #eff6ff !important; transform: scale(1.01); }
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
            @if($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                    <i class="fa-solid fa-circle-exclamation mt-0.5"></i>
                    <div>
                        <p class="font-medium">Tidak dapat menyimpan</p>
                        <p class="mt-1">{{ $errors->first() }}</p>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                                <i class="fa-solid fa-pen"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold text-slate-900">Edit Tiket #{{ $ticket->id }}</h1>
                                <p class="text-sm text-slate-500">Perbarui detail tiket berikut</p>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('tickets.update', $ticket) }}" enctype="multipart/form-data" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="title" class="block text-sm font-medium text-slate-700 mb-1.5">Judul tiket</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $ticket->title) }}" required
                                    class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all">
                                @error('title') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-slate-700 mb-1.5">Kategori</label>
                                    <div class="relative">
                                        <select name="category_id" id="category_id"
                                            class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all appearance-none">
                                            <option value="">Pilih kategori</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id', $ticket->category_id) == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-3 top-3 text-xs text-slate-400 pointer-events-none"></i>
                                    </div>
                                    @error('category_id') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="priority" class="block text-sm font-medium text-slate-700 mb-1.5">Prioritas</label>
                                    <div class="relative">
                                        <select name="priority" id="priority"
                                            class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all appearance-none">
                                            @foreach(['low','medium','high','critical'] as $p)
                                                <option value="{{ $p }}" {{ old('priority', $ticket->priority) === $p ? 'selected' : '' }}>
                                                    {{ ucfirst($p) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-3 top-3 text-xs text-slate-400 pointer-events-none"></i>
                                    </div>
                                    @error('priority') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                                    <div class="relative">
                                        <select name="status" id="status"
                                            class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all appearance-none">
                                            @foreach(['open','in_progress','resolved','closed'] as $s)
                                                <option value="{{ $s }}" {{ old('status', $ticket->status) === $s ? 'selected' : '' }}>
                                                    {{ ucfirst(str_replace('_', ' ', $s)) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-3 top-3 text-xs text-slate-400 pointer-events-none"></i>
                                    </div>
                                    @error('status') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label for="assigned_to" class="block text-sm font-medium text-slate-700 mb-1.5">Ditugaskan ke</label>
                                    <div class="relative">
                                        <select name="assigned_to" id="assigned_to"
                                            class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all appearance-none">
                                            <option value="">Tidak ada</option>
                                            @foreach(\App\Models\User::where('is_admin', true)->get() as $admin)
                                                <option value="{{ $admin->id }}" {{ old('assigned_to', $ticket->assigned_to) == $admin->id ? 'selected' : '' }}>
                                                    {{ $admin->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class="fa-solid fa-chevron-down absolute right-3 top-3 text-xs text-slate-400 pointer-events-none"></i>
                                    </div>
                                    @error('assigned_to') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                                <textarea name="description" id="description" rows="6" required
                                    class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all">{{ old('description', $ticket->description) }}</textarea>
                                @error('description') <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p> @enderror
                            </div>

                            <!-- Collapsible Upload Area -->
                            <div>
                                <button type="button" onclick="toggleUpload()" class="flex items-center gap-2 text-sm font-medium text-slate-700 hover:text-brand-600 transition-colors">
                                    <i id="uploadIcon" class="fa-solid fa-chevron-right text-xs transition-transform"></i>
                                    Ganti lampiran <span class="text-slate-400">(opsional)</span>
                                </button>
                                <div id="uploadArea" class="hidden mt-3">
                                    <div id="dropZone" class="drop-zone border-2 border-dashed border-slate-300 rounded-xl p-6 text-center cursor-pointer hover:border-brand-400 hover:bg-brand-50/40 transition-all">
                                        <input type="file" name="attachment" id="attachment" class="hidden" accept=".png,.jpg,.jpeg,.pdf,.zip,.doc,.docx">
                                        <div class="space-y-2">
                                            <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-400"></i>
                                            <div class="flex text-sm text-slate-600 justify-center">
                                                <label for="attachment" class="relative cursor-pointer rounded-md font-medium text-brand-600 hover:text-brand-500 focus-within:outline-none">
                                                    <span>Upload file baru</span>
                                                </label>
                                            </div>
                                            <p class="text-xs text-slate-500">PNG, JPG, PDF, ZIP, DOC hingga 5MB</p>
                                        </div>
                                    </div>
                                    <p id="fileName" class="mt-2 text-sm text-slate-600 hidden"></p>
                                    @error('attachment')
                                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                    @if($ticket->attachment_path)
                                        <p class="mt-2 text-sm text-slate-600">Lampiran saat ini: {{ basename($ticket->attachment_path) }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-3 pt-2">
                                <a href="{{ route('tickets.show', $ticket) }}" class="px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100">Kembali</a>
                                <button type="submit" class="btn-primary text-white px-5 py-2.5 rounded-xl text-sm font-medium">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleUpload() {
            const area = document.getElementById('uploadArea');
            const icon = document.getElementById('uploadIcon');
            area.classList.toggle('hidden');
            icon.classList.toggle('fa-chevron-right');
            icon.classList.toggle('fa-chevron-down');
        }

        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('attachment');
        const fileNameDisplay = document.getElementById('fileName');

        if (dropZone && fileInput) {
            dropZone.addEventListener('click', () => fileInput.click());

            dropZone.addEventListener('dragover', (e) => {
                e.preventDefault();
                dropZone.classList.add('drag-over');
            });

            dropZone.addEventListener('dragleave', () => {
                dropZone.classList.remove('drag-over');
            });

            dropZone.addEventListener('drop', (e) => {
                e.preventDefault();
                dropZone.classList.remove('drag-over');
                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                    fileNameDisplay.textContent = 'File terpilih: ' + e.dataTransfer.files[0].name;
                    fileNameDisplay.classList.remove('hidden');
                }
            });

            fileInput.addEventListener('change', () => {
                if (fileInput.files.length) {
                    fileNameDisplay.textContent = 'File terpilih: ' + fileInput.files[0].name;
                    fileNameDisplay.classList.remove('hidden');
                }
            });
        }
    </script>
</body>
</html>
