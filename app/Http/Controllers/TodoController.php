<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('todo.index', compact('todos'));
    }

    public function create()
    {
        return view('todo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,zip,doc,docx',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            $filename = sprintf('%s.%s', Str::random(40), $file->getClientOriginalExtension());
            $path = $file->storeAs('todo-attachments', $filename, 'private');

            $data['attachment_path'] = $path;
        }

        $todo = Todo::create($data);

        return redirect('/todo')->with('status', 'Todo berhasil ditambahkan');
    }

    public function show($id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);

        return view('todo.show', compact('todo'));
    }

    public function edit($id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);

        return view('todo.edit', compact('todo'));
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,zip,doc,docx',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');

            if ($todo->attachment_path && Storage::disk('private')->exists($todo->attachment_path)) {
                Storage::disk('private')->delete($todo->attachment_path);
            }

            $filename = sprintf('%s.%s', Str::random(40), $file->getClientOriginalExtension());
            $path = $file->storeAs('todo-attachments', $filename, 'private');

            $data['attachment_path'] = $path;
        }

        $todo->update($data);

        return redirect('/todo')->with('status', 'Todo berhasil diupdate');
    }

    public function destroy($id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);

        if ($todo->attachment_path && Storage::disk('private')->exists($todo->attachment_path)) {
            Storage::disk('private')->delete($todo->attachment_path);
        }

        $todo->delete();

        return redirect('/todo')->with('status', 'Todo berhasil dihapus');
    }

    public function download($id)
    {
        $todo = Todo::where('user_id', auth()->id())->findOrFail($id);

        if (! $todo->attachment_path || ! Storage::disk('private')->exists($todo->attachment_path)) {
            abort(404);
        }

        return Storage::disk('private')->download($todo->attachment_path);
    }
}
