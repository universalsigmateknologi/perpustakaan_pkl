@extends('layouts.app')

@section('title', 'Data Peminjaman')
@section('header_title', 'Transaksi Peminjaman Buku')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Riwayat Peminjaman</h2>
            <p class="text-sm text-gray-500">Daftar buku yang sedang dipinjam atau sudah dikembalikan.</p>
        </div>
        <a href="{{ route('loans.create') }}" class="inline-flex items-center justify-center bg-black text-white py-2.5 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
            Buat Peminjaman
        </a>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-50 border-l-2 border-green-500 text-green-700 text-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white border border-gray-200 p-4 rounded-sm">
        <form action="{{ route('loans.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Cari Transaksi</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode Pinjam / Kode Member / Nama" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Status</label>
                    <select name="status" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                        <option value="">Semua</option>
                        <option value="dipinjam" {{ request('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end space-x-3">
                <a href="{{ route('loans.index') }}" class="text-xs text-gray-500 hover:text-black py-2 px-4">Reset</a>
                <button type="submit" class="bg-gray-100 text-gray-800 py-2 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-200 transition-colors">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium">Kode Pinjam</th>
                        <th class="py-3 px-4 font-medium">Anggota</th>
                        <th class="py-3 px-4 font-medium">Tgl Pinjam</th>
                        <th class="py-3 px-4 font-medium">Batas Kembali</th>
                        <th class="py-3 px-4 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($loans as $loan)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-mono text-xs text-gray-600">{{ $loan->kode_pinjam }}</td>
                        <td class="py-3 px-4">
                            <p class="font-medium text-gray-900">{{ $loan->member->nama }}</p>
                            <p class="text-xs text-gray-400">{{ $loan->member->kode_member }}</p>
                        </td>
                        <td class="py-3 px-4 text-gray-600">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs {{ $loan->status == 'dipinjam' ? 'bg-blue-50 text-blue-700' : ($loan->status == 'terlambat' ? 'bg-red-50 text-red-700' : 'bg-green-50 text-green-700') }}">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-sm text-gray-400">Tidak ada data peminjaman.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200">{{ $loans->links() }}</div>
    </div>
</div>
@endsection