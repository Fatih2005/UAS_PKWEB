<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketStoreRequest;
use App\Http\Requests\TicketUpdateRequest;
use App\Models\Ticket;
use App\Models\TicketCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $tickets = Ticket::query()
            ->with(['user', 'category', 'assignee'])
            ->when(! $user->is_admin, function ($query) use ($user) {
                $query->where(function ($sub) use ($user) {
                    $sub->where('user_id', $user->id)
                        ->orWhere('assigned_to', $user->id);
                });
            })
            ->latest()
            ->paginate(20);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $categories = TicketCategory::orderBy('name')->get();

        return view('tickets.create', compact('categories'));
    }

    public function store(TicketStoreRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = Auth::id();
        $data['status'] = 'open';

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $filename = sprintf(
                '%s.%s',
                uniqid(),
                $file->getClientOriginalExtension()
            );

            $path = $file->storeAs('ticket-attachments', $filename, 'local');
            $data['attachment_path'] = $path;
        }

        $ticket = Ticket::create($data);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('status', 'Ticket berhasil dibuat');
    }

    public function show($ticket)
    {
        $ticket = Ticket::with(['user', 'category', 'assignee', 'comments.user'])->findOrFail($ticket);

        $user = Auth::user();
        if (! $user->is_admin && $ticket->user_id !== $user->id && $ticket->assigned_to !== $user->id) {
            abort(403);
        }

        $ticket->loadMissing(['comments.user']);

        return view('tickets.show', compact('ticket'));
    }

    public function attachment($ticket)
    {
        $ticket = Ticket::findOrFail($ticket);

        if (! $ticket->attachment_path || ! Storage::disk('local')->exists($ticket->attachment_path)) {
            abort(404);
        }

        $user = Auth::user();
        if (! $user->is_admin && $ticket->user_id !== $user->id && $ticket->assigned_to !== $user->id) {
            abort(403);
        }

        return Storage::disk('local')->download(
            $ticket->attachment_path,
            basename($ticket->attachment_path)
        );
    }

    public function edit($ticket)
    {
        $ticket = Ticket::findOrFail($ticket);

        if (! $ticket->canBeManagedBy(Auth::user())) {
            abort(403);
        }

        $categories = TicketCategory::orderBy('name')->get();

        return view('tickets.edit', compact('ticket', 'categories'));
    }

    public function update(TicketUpdateRequest $request, $ticket)
    {
        $ticket = Ticket::findOrFail($ticket);

        if (! $ticket->canBeManagedBy(Auth::user())) {
            abort(403);
        }

        $data = $request->validated();

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            if ($ticket->attachment_path && Storage::disk('local')->exists($ticket->attachment_path)) {
                Storage::disk('local')->delete($ticket->attachment_path);
            }

            $filename = sprintf(
                '%s.%s',
                uniqid(),
                $file->getClientOriginalExtension()
            );

            $path = $file->storeAs('ticket-attachments', $filename, 'local');
            $data['attachment_path'] = $path;
        }

        // Admin dapat mengubah semua field
        if (Auth::user()->is_admin) {
            $ticket->update($data);
        } else {
            // User hanya boleh mengubah field tertentu
            $ticket->update([
                'category_id' => $data['category_id'] ?? $ticket->category_id,
                'title' => $data['title'],
                'priority' => $data['priority'],
                'description' => $data['description'] ?? $ticket->description,
                'attachment_path' => $data['attachment_path'] ?? $ticket->attachment_path,
            ]);
        }

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('status', 'Ticket berhasil diperbarui');
    }

    public function destroy($ticket)
    {
        $ticket = Ticket::findOrFail($ticket);

        if (! $ticket->canBeManagedBy(Auth::user())) {
            abort(403);
        }

        if ($ticket->attachment_path && Storage::disk('local')->exists($ticket->attachment_path)) {
            Storage::disk('local')->delete($ticket->attachment_path);
        }

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('status', 'Ticket berhasil dihapus');
    }
}
