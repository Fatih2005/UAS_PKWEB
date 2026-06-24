@extends('layouts.app')

@section('title', 'Daftar Tiket')

@section('content')
<div class="flex items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Daftar Tiket</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola dan pantau semua tiket mereka</p>
    </div>

    <a href="{{ route('tickets.create') }}" class="btn-primary text-white px-4 py-2.5 rounded-xl text-sm font-medium inline-flex items-center gap-2">
        <i class="fa-solid fa-plus"></i> Buat Tiket
    </a>
</div>

<div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-slate-50/80 border-b border-slate-100">
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Prioritas</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Dibuat</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($tickets as $ticket)
                    <tr class="hover:bg-slate-50/60 transition-colors priority-{{ $ticket->priority }}">
                        <td class="px-6 py-4 text-sm font-mono text-slate-600">#{{ $ticket->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-900">{{ $ticket->title }}</div>
                            <div class="text-xs text-slate-500">{{ $ticket->category?->name ?? 'Tanpa Kategori' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $badge = match($ticket->priority) {
                                    'critical' => 'bg-red-50 text-red-700 ring-1 ring-red-600/10',
                                    'high' => 'bg-orange-50 text-orange-700 ring-1 ring-orange-600/10',
                                    'medium' => 'bg-yellow-50 text-yellow-700 ring-1 ring-yellow-600/10',
                                    default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-600/10',
                                };
                            @endphp
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $badge }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusBadge = match($ticket->status) {
                                    'open' => 'bg-blue-50 text-blue-700 ring-1 ring-blue-600/10',
                                    'in_progress' => 'bg-purple-50 text-purple-700 ring-1 ring-purple-600/10',
                                    'resolved' => 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-600/10',
                                    'closed' => 'bg-slate-100 text-slate-700 ring-1 ring-slate-600/10',
                                    default => 'bg-slate-100 text-slate-700 ring-1 ring-slate-600/10',
                                };
                            @endphp
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full {{ $statusBadge }}">
                                {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $ticket->created_at->diffForHumans() }}</td>
                        <td class="px-6 py-4 text-right text-sm">
                            <a href="{{ route('tickets.show', $ticket) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-600 hover:text-brand-600 hover:bg-brand-50 transition-colors">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-inbox text-2xl text-slate-400"></i>
                                </div>
                                <p class="text-slate-500 font-medium">Belum ada tiket</p>
                                <p class="text-sm text-slate-400 mt-1">Buat tiket pertama untuk memulai</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $tickets->links() }}
</div>
@endsection
