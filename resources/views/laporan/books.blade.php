@extends('layouts.app')

@section('title', 'Laporan Buku')
@section('header_title', 'Laporan Data Buku')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="{{ route('admin.reports.index') }}" class="text-xs text-gray-500 hover:text-black">&larr; Menu Laporan</a>
            <h2 class="text-lg font-medium text-gray-900 mt-2">Rekapitulasi Data Buku</h2>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.reports.books.pdf') }}" target="_blank" class="inline-flex items-center justify-center bg-white border border-gray-300 text-gray-700 py-2.5 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-50">Export PDF</a>
            <a href="{{ route('admin.reports.books.excel') }}" class="inline-flex items-center justify-center bg-white border border-gray-300 text-gray-700 py-2.5 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-50">Export Excel</a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-2 gap-4">
        <div class="bg-white border border-gray-200 p-5 rounded-sm">
            <p class="text-xs uppercase tracking-wider text-gray-500">Total Judul Buku</p>
            <h3 class="text-2xl font-light text-gray-900 mt-2">{{ $books->count() }}</h3>
        </div>
        <div class="bg-white border border-gray-200 p-5 rounded-sm">
            <p class="text-xs uppercase tracking-wider text-gray-500">Total Eksemplar (Stok)</p>
            <h3 class="text-2xl font-light text-gray-900 mt-2">{{ $totalStok }} <span class="text-sm text-gray-400">({{ $totalTersedia }} tersedia)</span></h3>
        </div>
    </div>

    <!-- Tabel -->
    <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium">Kode</th>
                        <th class="py-3 px-4 font-medium">Judul</th>
                        <th class="py-3 px-4 font-medium">Kategori</th>
                        <th class="py-3 px-4 font-medium text-center">Total</th>
                        <th class="py-3 px-4 font-medium text-center">Tersedia</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($books as $book)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-mono text-xs text-gray-600">{{ $book->kode_buku }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900">{{ $book->judul }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ $book->category->nama_kategori ?? '-' }}</td>
                        <td class="py-3 px-4 text-center text-gray-900">{{ $book->jumlah }}</td>
                        <td class="py-3 px-4 text-center font-medium text-green-600">{{ $book->tersedia }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-sm text-gray-400">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection