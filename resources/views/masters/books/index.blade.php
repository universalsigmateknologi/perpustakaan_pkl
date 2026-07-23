@extends('layouts.app')

@section('title', 'Master Buku')
@section('header_title', 'Master Data Buku')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Daftar Koleksi Buku</h2>
            <p class="text-sm text-gray-500">Kelola data buku perpustakaan.</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="inline-flex items-center justify-center bg-black text-white py-2.5 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
            Tambah Buku
        </a>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-50 border-l-2 border-green-500 text-green-700 text-sm">{{ session('success') }}</div>
    @endif

    <!-- Form Filter & Search -->
    <div class="bg-white border border-gray-200 p-4 rounded-sm">
        <form action="{{ route('admin.books.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                <!-- Search -->
                <div class="lg:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Cari Buku</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Judul / Kode / ISBN" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                </div>
                <!-- Filter Kategori -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Kategori</label>
                    <select name="category_id" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                        <option value="">Semua</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Filter Penulis -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Penulis</label>
                    <select name="author_id" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                        <option value="">Semua</option>
                        @foreach($authors as $aut)
                            <option value="{{ $aut->id }}" {{ request('author_id') == $aut->id ? 'selected' : '' }}>{{ $aut->nama_penulis }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Filter Rak -->
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Rak</label>
                    <select name="shelf_id" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                        <option value="">Semua</option>
                        @foreach($shelves as $sh)
                            <option value="{{ $sh->id }}" {{ request('shelf_id') == $sh->id ? 'selected' : '' }}>{{ $sh->nama_rak }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end space-x-3">
                <a href="{{ route('admin.books.index') }}" class="text-xs text-gray-500 hover:text-black py-2 px-4">Reset</a>
                <button type="submit" class="bg-gray-100 text-gray-800 py-2 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-200 transition-colors">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <!-- Tabel Buku -->
    <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium">Kode</th>
                        <th class="py-3 px-4 font-medium">Judul</th>
                        <th class="py-3 px-4 font-medium">Penulis</th>
                        <th class="py-3 px-4 font-medium">Kategori</th>
                        <th class="py-3 px-4 font-medium text-center">Stok</th>
                        <th class="py-3 px-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($books as $book)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-mono text-xs text-gray-600">{{ $book->kode_buku }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center space-x-3">
                                <img src="{{ $book->cover ? asset('storage/' . $book->cover) : 'https://ui-avatars.com/api/?name=' . urlencode($book->judul) . '&color=000000&background=EEEEEE&size=40' }}" alt="Cover" class="w-8 h-10 object-cover border border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $book->judul }}</p>
                                    <p class="text-xs text-gray-400">{{ $book->isbn ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-3 px-4 text-gray-600">{{ $book->author->nama_penulis ?? '-' }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $book->category->nama_kategori ?? '-' }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="font-medium text-gray-900">{{ $book->tersedia }}</span>
                            <span class="text-gray-400">/ {{ $book->jumlah }}</span>
                        </td>
                        <td class="py-3 px-4 text-right space-x-3">
                            <a href="{{ route('admin.books.edit', $book) }}" class="text-gray-500 hover:text-black">Edit</a>
                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus buku ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-6 text-center text-sm text-gray-400">Tidak ada data buku ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200">{{ $books->links() }}</div>
    </div>
</div>
@endsection