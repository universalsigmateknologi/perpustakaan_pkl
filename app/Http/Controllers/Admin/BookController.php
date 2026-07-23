<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Shelve;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input filter & search
        $search = $request->input('search');
        $category = $request->input('category_id');
        $author = $request->input('author_id');
        $publisher = $request->input('publisher_id');
        $shelf = $request->input('shelf_id');

        // Query dengan filter
        $books = Book::with(['category', 'author', 'publisher', 'shelf'])
            ->when($search, function ($query) use ($search) {
                $query->where('judul', 'like', "%{$search}%")
                      ->orWhere('kode_buku', 'like', "%{$search}%")
                      ->orWhere('isbn', 'like', "%{$search}%");
            })
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category);
            })
            ->when($author, function ($query) use ($author) {
                $query->where('author_id', $author);
            })
            ->when($publisher, function ($query) use ($publisher) {
                $query->where('publisher_id', $publisher);
            })
            ->when($shelf, function ($query) use ($shelf) {
                $query->where('shelf_id', $shelf);
            })
            ->latest()
            ->paginate(10);

        // Ambil data untuk dropdown filter
        $categories = Category::orderBy('nama_kategori')->get();
        $authors = Author::orderBy('nama_penulis')->get();
        $publishers = Publisher::orderBy('nama_penerbit')->get();
        $shelves = Shelve::orderBy('nama_rak')->get();

        return view('masters.books.index', compact('books', 'categories', 'authors', 'publishers', 'shelves'));
    }

    public function create()
    {
        $categories = Category::orderBy('nama_kategori')->get();
        $authors = Author::orderBy('nama_penulis')->get();
        $publishers = Publisher::orderBy('nama_penerbit')->get();
        $shelves = Shelve::orderBy('nama_rak')->get();

        return view('masters.books.create', compact('categories', 'authors', 'publishers', 'shelves'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'isbn'         => 'nullable|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'author_id'    => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'shelf_id'     => 'nullable|exists:shelves,id',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah'       => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi'    => 'nullable|string',
        ]);

        // Generate kode buku (BK-0001)
        $lastBook = Book::latest('id')->first();
        $lastNumber = $lastBook ? (int) str_replace('BK-', '', $lastBook->kode_buku) : 0;
        $validated['kode_buku'] = 'BK-' . str_pad($lastNumber + 1, 5, '0', STR_PAD_LEFT);

        // Stok tersedia awal sama dengan jumlah total
        $validated['tersedia'] = $validated['jumlah'];

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')
                         ->with('success', 'Data buku berhasil ditambahkan.');
    }

    public function edit(Book $book)
    {
        $categories = Category::orderBy('nama_kategori')->get();
        $authors = Author::orderBy('nama_penulis')->get();
        $publishers = Publisher::orderBy('nama_penerbit')->get();
        $shelves = Shelve::orderBy('nama_rak')->get();

        return view('masters.books.edit', compact('book', 'categories', 'authors', 'publishers', 'shelves'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'judul'        => 'required|string|max:255',
            'isbn'         => 'nullable|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'author_id'    => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
            'shelf_id'     => 'nullable|exists:shelves,id',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'jumlah'       => 'required|integer|min:0',
            'cover'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'deskripsi'    => 'nullable|string',
        ]);

        // Logika update stok tersedia jika jumlah total diubah
        $selisih = $validated['jumlah'] - $book->jumlah;
        $validated['tersedia'] = $book->tersedia + $selisih;
        if ($validated['tersedia'] < 0) $validated['tersedia'] = 0; // Pencegahan negatif

        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')
                         ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();

        return redirect()->route('admin.books.index')
                         ->with('success', 'Data buku berhasil dihapus.');
    }
}