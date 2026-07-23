@extends('layouts.app')

@section('title', 'Pengembalian Buku')
@section('header_title', 'Proses Pengembalian Buku')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Transaksi Aktif</h2>
            <p class="text-sm text-gray-500">Cari anggota yang ingin mengembalikan buku, lalu klik tombol proses.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-50 border-l-2 border-green-500 text-green-700 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-red-50 border-l-2 border-red-500 text-red-700 text-sm">{{ session('error') }}</div>
    @endif

    <!-- Form Search -->
    <div class="bg-white border border-gray-200 p-4 rounded-sm">
        <form action="{{ route('book_returns.index') }}" method="GET">
            <div class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari Kode Pinjam / Kode Member / Nama..." class="flex-1 px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                <button type="submit" class="bg-gray-100 text-gray-800 py-2 px-6 text-xs uppercase tracking-widest font-medium hover:bg-gray-200 transition-colors">Cari</button>
            </div>
        </form>
    </div>

    <!-- Tabel Transaksi Aktif -->
    <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium">Kode Pinjam</th>
                        <th class="py-3 px-4 font-medium">Anggota</th>
                        <th class="py-3 px-4 font-medium">Buku yang Dipinjam</th>
                        <th class="py-3 px-4 font-medium">Batas Kembali</th>
                        <th class="py-3 px-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($loans as $loan)
                    <tr class="hover:bg-gray-50 align-top">
                        <td class="py-3 px-4 font-mono text-xs text-gray-600">{{ $loan->kode_pinjam }}</td>
                        <td class="py-3 px-4">
                            <p class="font-medium text-gray-900">{{ $loan->member->nama }}</p>
                            <p class="text-xs text-gray-400">{{ $loan->member->kode_member }}</p>
                        </td>
                        <td class="py-3 px-4">
                            <ul class="list-disc list-inside text-xs text-gray-600 space-y-1">
                                @foreach($loan->details as $detail)
                                    <li>{{ $detail->book->judul }} <span class="text-gray-400">({{ $detail->book->kode_buku }})</span></li>
                                @endforeach
                            </ul>
                        </td>
                        <td class="py-3 px-4">
                            @php
                                $dueDate = \Carbon\Carbon::parse($loan->tanggal_kembali);
                                $isLate = \Carbon\Carbon::now()->startOfDay()->gt($dueDate->startOfDay());
                            @endphp
                            <p class="text-gray-900 {{ $isLate ? 'text-red-600 font-medium' : '' }}">{{ $dueDate->format('d M Y') }}</p>
                            @if($isLate)
                                <p class="text-xs text-red-500 mt-1">Terlambat!</p>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            <form action="{{ route('book_returns.process', $loan) }}" method="POST" onsubmit="return confirm('Proses pengembalian buku untuk anggota {{ $loan->member->nama }}? Stok buku akan dikembalikan.')">
                                @csrf
                                <button type="submit" class="bg-black text-white py-2 px-4 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
                                    Proses Kembalikan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-sm text-gray-400">Tidak ada transaksi peminjaman aktif.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200">{{ $loans->links() }}</div>
    </div>
</div>
@endsection