<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shelve;

class ShelfController extends Controller
{
    /**
     * Menampilkan daftar rak/etalase
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $shelves = Shelve::when($search, function ($query) use ($search) {
            $query->where('nama_rak', 'like', "%{$search}%")
                  ->orWhere('kode_rak', 'like', "%{$search}%")
                  ->orWhere('tipe', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('masters.etalase.index', compact('shelves'));
    }

    /**
     * Menampilkan form tambah rak
     */
    public function create()
    {
        return view('masters.etalase.create');
    }

    /**
     * Menyimpan rak baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_rak'  => 'required|string|max:255',
            'tipe'      => 'required|in:rak,etalase',
            'lokasi'    => 'nullable|string|max:255',
            'kapasitas' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        // Generate kode rak otomatis berdasarkan tipe
        $prefix = $validated['tipe'] === 'rak' ? 'RAK-' : 'ETL-';
        $lastItem = Shelve::where('kode_rak', 'like', $prefix . '%')->latest('id')->first();
        $lastNumber = $lastItem ? (int) str_replace($prefix, '', $lastItem->kode_rak) : 0;
        $validated['kode_rak'] = $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        Shelve::create($validated);

        return redirect()->route('admin.etalase.index')
                         ->with('success', 'Data rak/etalase berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit rak
     */
    public function edit(Shelve $etalase)
    {
        return view('masters.etalase.edit', ['shelf' => $etalase]);
    }

    /**
     * Memperbarui data rak
     */
    public function update(Request $request, Shelve $etalase)
    {
        $validated = $request->validate([
            'nama_rak'  => 'required|string|max:255',
            'lokasi'    => 'nullable|string|max:255',
            'kapasitas' => 'required|integer|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        // Tipe tidak diubah saat edit agar kode_rak tidak inkonsisten
        $etalase->update($validated);

        return redirect()->route('admin.etalase.index')
                         ->with('success', 'Data rak/etalase berhasil diperbarui.');
    }

    /**
     * Menghapus rak
     */
    public function destroy(Shelve $etalase)
    {
        // Karena di tabel books foreignId ke shelves onDelete('set null'),
        // menghapus rak akan membuat kolom shelf_id pada buku terkait menjadi NULL.
        $etalase->delete();

        return redirect()->route('admin.etalase.index')
                         ->with('success', 'Data rak/etalase berhasil dihapus.');
    }
}