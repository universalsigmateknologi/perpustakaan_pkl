<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $authors = Author::when($search, function ($query) use ($search) {
            $query->where('nama_penulis', 'like', "%{$search}%")
                  ->orWhere('kode_penulis', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('masters.writer_publisher.authors_index', compact('authors'));
    }

    public function create()
    {
        return view('masters.writer_publisher.authors_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penulis' => 'required|string|max:255',
            'biografi'     => 'nullable|string',
        ]);

        // Generate kode penulis (PNL-0001)
        $lastItem = Author::latest('id')->first();
        $lastNumber = $lastItem ? (int) str_replace('PNL-', '', $lastItem->kode_penulis) : 0;
        $validated['kode_penulis'] = 'PNL-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        Author::create($validated);

        return redirect()->route('admin.authors.index')
                         ->with('success', 'Data penulis berhasil ditambahkan.');
    }

    public function edit(Author $author)
    {
        return view('masters.writer_publisher.authors_edit', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $validated = $request->validate([
            'nama_penulis' => 'required|string|max:255',
            'biografi'     => 'nullable|string',
        ]);

        $author->update($validated);

        return redirect()->route('admin.authors.index')
                         ->with('success', 'Data penulis berhasil diperbarui.');
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('admin.authors.index')
                         ->with('success', 'Data penulis berhasil dihapus.');
    }
}