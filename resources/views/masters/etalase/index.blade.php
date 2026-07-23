@extends('layouts.app')

@section('title', 'Master Rak & Etalase')
@section('header_title', 'Master Data Rak & Etalase')

@section('content')
<div class="space-y-6">
    
    <!-- Header & Tombol Tambah -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Daftar Lokasi Penyimpanan</h2>
            <p class="text-sm text-gray-500">Kelola rak dan etalase untuk lokasi buku.</p>
        </div>
        <a href="{{ route('admin.etalase.create') }}" class="inline-flex items-center justify-center bg-black text-white py-2.5 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
            Tambah Rak/Etalase
        </a>
    </div>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="p-3 bg-green-50 border-l-2 border-green-500 text-green-700 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Data Rak -->
    <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium">Kode</th>
                        <th class="py-3 px-4 font-medium">Tipe</th>
                        <th class="py-3 px-4 font-medium">Nama</th>
                        <th class="py-3 px-4 font-medium">Lokasi</th>
                        <th class="py-3 px-4 font-medium">Kapasitas</th>
                        <th class="py-3 px-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($shelves as $shelf)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-mono text-xs text-gray-600">{{ $shelf->kode_rak }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs {{ $shelf->tipe == 'rak' ? 'bg-gray-100 text-gray-700' : 'bg-blue-50 text-blue-700' }}">
                                {{ ucfirst($shelf->tipe) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 font-medium text-gray-900">{{ $shelf->nama_rak }}</td>
                        <td class="py-3 px-4 text-gray-500">{{ $shelf->lokasi ?? '-' }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $shelf->kapasitas }} Buku</td>
                        <td class="py-3 px-4 text-right space-x-3">
                            <a href="{{ route('admin.etalase.edit', $shelf) }}" class="text-gray-500 hover:text-black">Edit</a>
                            <form action="{{ route('admin.etalase.destroy', $shelf) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin hapus rak ini? Buku di dalamnya akan menjadi tanpa rak.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-6 text-center text-sm text-gray-400">Tidak ada data rak/etalase.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200">
            {{ $shelves->links() }}
        </div>
    </div>

</div>
@endsection