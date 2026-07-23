@extends('layouts.app')

@section('title', 'Master Penulis')
@section('header_title', 'Master Data Penulis & Penerbit')

@section('content')
<div class="space-y-6">
    
    <!-- Navigasi Tab -->
    <div class="border-b border-gray-200">
        <nav class="flex space-x-8" aria-label="Tabs">
            <a href="{{ route('admin.authors.index') }}" class="border-gray-900 text-gray-900 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Penulis</a>
            <a href="{{ route('admin.publishers.index') }}" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">Penerbit</a>
        </nav>
    </div>

    <!-- Header & Tombol Tambah -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Daftar Penulis</h2>
            <p class="text-sm text-gray-500">Kelola data penulis buku.</p>
        </div>
        <a href="{{ route('admin.authors.create') }}" class="inline-flex items-center justify-center bg-black text-white py-2.5 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
            Tambah Penulis
        </a>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-50 border-l-2 border-green-500 text-green-700 text-sm">{{ session('success') }}</div>
    @endif

    <!-- Tabel -->
    <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium">Kode</th>
                        <th class="py-3 px-4 font-medium">Nama Penulis</th>
                        <th class="py-3 px-4 font-medium">Biografi</th>
                        <th class="py-3 px-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($authors as $author)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-mono text-xs text-gray-600">{{ $author->kode_penulis }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900">{{ $author->nama_penulis }}</td>
                        <td class="py-3 px-4 text-gray-500 max-w-md truncate">{{ $author->biografi ?? '-' }}</td>
                        <td class="py-3 px-4 text-right space-x-3">
                            <a href="{{ route('admin.authors.edit', $author) }}" class="text-gray-500 hover:text-black">Edit</a>
                            <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus penulis ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="py-6 text-center text-sm text-gray-400">Tidak ada data penulis.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200">{{ $authors->links() }}</div>
    </div>
</div>
@endsection