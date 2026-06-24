<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\GuestbookEntry;
use App\Models\Todo;

class GuestbookController extends Controller
{
    public function index()
    {
        $entries = GuestbookEntry::latest()->get();
        return view('guestbook.index', compact('entries'));
    }

    // VULNERABLE: SQL Injection
    public function search(Request $request)
    {
        $search = $request->input('q');

        // VULNERABLE: raw whereRaw still allows SQL injection, but returns Eloquent models so dates work in view
        $results = GuestbookEntry::whereRaw("name LIKE '%" . $search . "%' OR message LIKE '%" . $search . "%'")->get();

        return view('guestbook.index', [
            'entries' => $results,
            'search' => $search,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // VULNERABLE: user input stored as-is without sanitization (output is raw in view)
        $entry = GuestbookEntry::create([
            'name' => $request->input('name'),
            'message' => $request->input('message'),
        ]);

        return redirect('/guestbook')->with('status', 'Pesan berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $entry = GuestbookEntry::findOrFail($id);
        $entry->delete();

        return redirect('/guestbook')->with('status', 'Pesan berhasil dihapus');
    }
}
