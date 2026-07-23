@extends('layouts.app')

@section('title', 'Manajemen Denda')
@section('header_title', 'Data Denda Anggota')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h2 class="text-lg font-medium text-gray-900">Daftar Denda</h2>
            <p class="text-sm text-gray-500">Kelola pembayaran denda keterlambatan anggota.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 bg-green-50 border-l-2 border-green-500 text-green-700 text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="p-3 bg-red-50 border-l-2 border-red-500 text-red-700 text-sm">{{ session('error') }}</div>
    @endif

    <!-- Form Filter & Search -->
    <div class="bg-white border border-gray-200 p-4 rounded-sm">
        <form action="{{ route('denda.index') }}" method="GET">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Cari Denda</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode Denda / Kode Member / Nama" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Status Pembayaran</label>
                    <select name="status" class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm text-gray-900 focus:border-black transition-colors">
                        <option value="">Semua</option>
                        <option value="belum_bayar" {{ request('status') == 'belum_bayar' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
            </div>
            <div class="mt-4 flex justify-end space-x-3">
                <a href="{{ route('denda.index') }}" class="text-xs text-gray-500 hover:text-black py-2 px-4">Reset</a>
                <button type="submit" class="bg-gray-100 text-gray-800 py-2 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-200 transition-colors">Terapkan Filter</button>
            </div>
        </form>
    </div>

    <!-- Tabel Denda -->
    <div class="bg-white border border-gray-200 rounded-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="py-3 px-4 font-medium">Kode Denda</th>
                        <th class="py-3 px-4 font-medium">Anggota</th>
                        <th class="py-3 px-4 font-medium">Keterangan</th>
                        <th class="py-3 px-4 font-medium">Jumlah</th>
                        <th class="py-3 px-4 font-medium">Status</th>
                        <th class="py-3 px-4 font-medium text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($fines as $fine)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4 font-mono text-xs text-gray-600">{{ $fine->kode_denda }}</td>
                        <td class="py-3 px-4">
                            <p class="font-medium text-gray-900">{{ $fine->member->nama }}</p>
                            <p class="text-xs text-gray-400">{{ $fine->member->kode_member }}</p>
                        </td>
                        <td class="py-3 px-4 text-gray-600 max-w-xs truncate">{{ $fine->keterangan }}</td>
                        <td class="py-3 px-4 font-medium text-gray-900">Rp {{ number_format($fine->jumlah, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs {{ $fine->status == 'lunas' ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700' }}">
                                {{ ucfirst(str_replace('_', ' ', $fine->status)) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            @if($fine->status == 'belum_bayar')
                            <form action="{{ route('denda.pay', $fine) }}" method="POST" onsubmit="return confirm('Konfirmasi pembayaran denda Rp {{ number_format($fine->jumlah, 0, ',', '.') }} oleh {{ $fine->member->nama }}?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="bg-black text-white py-2 px-4 text-xs uppercase tracking-widest font-medium hover:bg-gray-800 transition-colors">
                                    Lunasi
                                </button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($fine->tanggal_bayar)->format('d M Y') }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-6 text-center text-sm text-gray-400">Tidak ada data denda ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 py-3 border-t border-gray-200">{{ $fines->links() }}</div>
    </div>
</div>
@endsection