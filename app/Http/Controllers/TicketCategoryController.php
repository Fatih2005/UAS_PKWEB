<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\TicketCategoryRequest;
use App\Models\TicketCategory;
use Illuminate\Support\Str;

class TicketCategoryController extends Controller
{
    public function index()
    {
        $categories = TicketCategory::orderBy('name')->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(TicketCategoryRequest $request)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        TicketCategory::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori berhasil ditambahkan');
    }

    public function edit($ticketCategory)
    {
        $category = TicketCategory::findOrFail($ticketCategory);

        return view('categories.edit', compact('category'));
    }

    public function update(TicketCategoryRequest $request, $ticketCategory)
    {
        $category = TicketCategory::findOrFail($ticketCategory);

        $category->update($request->validated());

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori berhasil diperbarui');
    }

    public function destroy($ticketCategory)
    {
        $category = TicketCategory::findOrFail($ticketCategory);

        if ($category->tickets()->exists()) {
            return redirect()
                ->back()
                ->with('error', 'Kategori memiliki ticket terkait');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('status', 'Kategori berhasil dihapus');
    }
}
