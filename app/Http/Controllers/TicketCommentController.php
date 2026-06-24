<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCommentRequest;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketCommentController extends Controller
{
    public function store(TicketCommentRequest $request, Ticket $ticket)
    {
        $payload = $request->validated();
        $payload['ticket_id'] = $ticket->id;
        $payload['user_id'] = Auth::id();

        $ticket->comments()->create($payload);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('status', 'Komentar berhasil ditambahkan');
    }

    public function destroy(Ticket $ticket, $commentId)
    {
        $comment = $ticket->comments()->whereKey($commentId)->firstOrFail();

        if ($comment->user_id !== Auth::id() && ! Auth::user()->is_admin) {
            abort(403);
        }

        $comment->delete();

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('status', 'Komentar berhasil dihapus');
    }
}
