<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::when($search, function ($query) use ($search) {
            $query->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('kode_kategori', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('masters.categories.index', compact('categories'));
    }

    /**
     * Menampilkan form tambah kategori
     */
    public function create()
    {
        return view('masters.categories.create');
    }

    /**
     * Menyimpan kategori baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
        ]);

        // Generate kode kategori otomatis (KAT-0001, KAT-0002, ...)
        $lastCategory = Category::latest('id')->first();
        $lastNumber = $lastCategory ? (int) str_replace('KAT-', '', $lastCategory->kode_kategori) : 0;
        $newNumber = $lastNumber + 1;
        $validated['kode_kategori'] = 'KAT-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit kategori
     */
    public function edit(Category $category)
    {
        return view('masters.categories.edit', compact('category'));
    }

    /**
     * Memperbarui data kategori
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Menghapus kategori
     */
    public function destroy(Category $category)
    {
        // Catatan: Karena tabel books foreignId ke categories onDelete('cascade'),
        // menghapus kategori akan menghapus semua buku di dalamnya.
        $category->delete();

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Kategori berhasil dihapus.');
    }
}