<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $ticket->title }} #{{ $ticket->id }} - PT. Ujug-Ujug</title>
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
                    <span class="text-sm font-medium text-slate-900">#{{ $ticket->id }}</span>
                </div>
                <div class="flex items-center gap-1">
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
                        <div class="flex flex-wrap items-start justify-between gap-4 mb-6">
                            <div>
                                <h1 class="text-xl font-bold text-slate-900">{{ $ticket->title }}</h1>
                                <p class="text-sm text-slate-500 mt-1">Tiket #{{ $ticket->id }} &middot; {{ $ticket->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex items-center gap-2">
                                @if(auth()->user()->is_admin)
                                    <form method="POST" action="{{ route('tickets.update', $ticket) }}" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="title" value="{{ $ticket->title }}">
                                        <input type="hidden" name="description" value="{{ $ticket->description }}">
                                        <input type="hidden" name="priority" value="{{ $ticket->priority }}">
                                        <select name="status" onchange="this.form.submit()"
                                            class="rounded-xl border border-slate-200 bg-slate-50 text-xs font-medium text-slate-700 px-2 py-2 focus:border-brand-500 focus:ring-brand-500/20">
                                            @foreach(['open'=>'Open','in_progress'=>'In Progress','resolved'=>'Resolved','closed'=>'Closed'] as $value => $label)
                                                <option value="{{ $value }}" {{ $ticket->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </form>
                                @endif
                                @if($ticket->canBeManagedBy(auth()->user()))
                                    <a href="{{ route('tickets.edit', $ticket) }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-slate-700 hover:bg-slate-100 border border-slate-200">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </a>
                                    <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" id="deleteTicketForm" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="openDeleteModal('ticket')" class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-sm font-medium text-red-700 hover:bg-red-50 border border-red-200">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-6">
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <p class="text-xs text-slate-500 mb-1">Kategori</p>
                                <p class="font-medium text-slate-900">{{ $ticket->category?->name ?? 'N/A' }}</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <p class="text-xs text-slate-500 mb-1">Prioritas</p>
                                <p class="font-medium text-slate-900 capitalize">{{ $ticket->priority }}</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <p class="text-xs text-slate-500 mb-1">Status</p>
                                <p class="font-medium text-slate-900 capitalize">{{ str_replace('_',' ',$ticket->status) }}</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 border border-slate-100 p-3">
                                <p class="text-xs text-slate-500 mb-1">Pelapor</p>
                                <p class="font-medium text-slate-900">{{ $ticket->user->name }}</p>
                            </div>
                        </div>

                        <div class="prose prose-slate max-w-none">
                            <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-2">Deskripsi</h3>
                            <div class="text-slate-800 whitespace-pre-line leading-relaxed">{{ $ticket->description }}</div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                                <i class="fa-solid fa-comments"></i>
                            </div>
                            <div>
                                <h2 class="text-base font-semibold text-slate-900">Komentar</h2>
                                <p class="text-xs text-slate-500">{{ $ticket->comments->count() }} komentar</p>
                            </div>
                        </div>

                        <div class="space-y-0 divide-y divide-slate-100">
                            @forelse($ticket->comments as $comment)
                                <div class="py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-brand-400 to-brand-700 text-white text-xs font-semibold flex items-center justify-center">
                                                {{ substr($comment->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="text-sm font-medium text-slate-900">{{ $comment->user->name }}</p>
                                                <p class="text-xs text-slate-500">{{ $comment->created_at->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        @if($comment->user_id === auth()->id() || auth()->user()->is_admin)
                                            <form method="POST" action="{{ route('tickets.comments.destroy', [$ticket, $comment->id]) }}" class="inline" id="deleteCommentForm-{{ $comment->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="openDeleteModal('comment-{{ $comment->id }}')" class="text-xs text-red-600 hover:text-red-700 font-medium">Hapus</button>
                                            </form>
                                        @endif
                                    </div>
                                    <p class="mt-2 text-sm text-slate-800 whitespace-pre-line leading-relaxed">{{ $comment->body }}</p>
                                </div>
                            @empty
                                <div class="py-10 text-center">
                                    <p class="text-sm text-slate-500">Belum ada komentar.</p>
                                </div>
                            @endforelse
                        </div>

                        <form method="POST" action="{{ route('tickets.comments.store', $ticket) }}" class="mt-5">
                            @csrf
                            <label for="body" class="block text-sm font-medium text-slate-700 mb-1.5">Tulis komentar</label>
                            <textarea name="body" id="body" rows="3" required
                                class="w-full rounded-xl border-slate-300 bg-white shadow-sm focus:border-brand-500 focus:ring-brand-500/20 transition-all"
                                placeholder="Tulis balasan atau update..."></textarea>
                            @error('body')
                                <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-3 flex justify-end">
                                <button type="submit" class="btn-primary text-white px-4 py-2 rounded-xl text-sm font-medium">Kirim Komentar</button>
                            </div>
                        </form>
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
                        <h3 class="text-sm font-semibold text-slate-900 mb-3">Detail tiket</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Pelapor</p>
                                    <p class="font-medium text-slate-900">{{ $ticket->user->name }}</p>
                                </div>
                            </div>
                            @if($ticket->assigned_to)
                                <div class="flex items-start gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-xs">
                                        <i class="fa-solid fa-user-gear"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-500">Ditugaskan ke</p>
                                        <p class="font-medium text-slate-900">{{ $ticket->assignee->name }}</p>
                                    </div>
                                </div>
                            @endif
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-folder"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Kategori</p>
                                    <p class="font-medium text-slate-900">{{ $ticket->category?->name ?? 'Tanpa kategori' }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-xs">
                                    <i class="fa-solid fa-calendar"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500">Dibuat</p>
                                    <p class="font-medium text-slate-900">{{ $ticket->created_at->format('d M Y H:i') }}</p>
                                </div>
                                @if($ticket->attachment_path)
                                    <div class="flex items-start gap-3 col-span-2 md:col-span-4">
                                        <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center text-xs">
                                            <i class="fa-solid fa-paperclip"></i>
                                        </div>
                                        <div>
                                            <p class="text-xs text-slate-500">Lampiran</p>
                                            <a href="{{ route('tickets.attachment', $ticket) }}" class="font-medium text-brand-600 hover:text-brand-700 underline">
                                                {{ basename($ticket->attachment_path) }}
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </main>
    <!-- Custom delete confirmation modal -->
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
    function openDeleteModal(type) {
        const modal = document.getElementById('confirmationModal');
        const message = document.getElementById('modalMessage');
        let form;
        if (type === 'ticket') {
            form = document.getElementById('deleteTicketForm');
        } else if (String(type).startsWith('comment-')) {
            const id = String(type).replace('comment-', '');
            form = document.getElementById('deleteCommentForm-' + id);
        }
        if (!form) return;
        message.textContent = type === 'ticket'
            ? 'Apakah kamu yakin ingin menghapus tiket ini? Aksi ini tidak dapat dibatalkan.'
            : 'Apakah kamu yakin ingin menghapus komentar ini?';
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
