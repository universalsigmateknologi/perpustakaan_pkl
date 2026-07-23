<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $publishers = Publisher::when($search, function ($query) use ($search) {
            $query->where('nama_penerbit', 'like', "%{$search}%")
                  ->orWhere('kode_penerbit', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('masters.writer_publisher.publishers_index', compact('publishers'));
    }

    public function create()
    {
        return view('masters.writer_publisher.publishers_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_penerbit' => 'required|string|max:255',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
        ]);

        // Generate kode penerbit (PNB-0001)
        $lastItem = Publisher::latest('id')->first();
        $lastNumber = $lastItem ? (int) str_replace('PNB-', '', $lastItem->kode_penerbit) : 0;
        $validated['kode_penerbit'] = 'PNB-' . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        Publisher::create($validated);

        return redirect()->route('admin.publishers.index')
                         ->with('success', 'Data penerbit berhasil ditambahkan.');
    }

    public function edit(Publisher $publisher)
    {
        return view('masters.writer_publisher.publishers_edit', compact('publisher'));
    }

    public function update(Request $request, Publisher $publisher)
    {
        $validated = $request->validate([
            'nama_penerbit' => 'required|string|max:255',
            'alamat'        => 'nullable|string',
            'telepon'       => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:255',
        ]);

        $publisher->update($validated);

        return redirect()->route('admin.publishers.index')
                         ->with('success', 'Data penerbit berhasil diperbarui.');
    }

    public function destroy(Publisher $publisher)
    {
        $publisher->delete();
        return redirect()->route('admin.publishers.index')
                         ->with('success', 'Data penerbit berhasil dihapus.');
    }
}