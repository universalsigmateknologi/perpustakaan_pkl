@extends('layouts.app')

@section('title', 'Dashboard Petugas')
@section('header_title', 'Dashboard Petugas')

@section('content')
<div class="space-y-6">
    
    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white border border-gray-200 p-5 rounded-sm">
            <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Buku Tersedia</p>
            <h3 class="text-3xl font-light text-gray-900 mt-2">{{ $availableBooks }}</h3>
            <p class="text-xs text-gray-400 mt-2">Siap Dipinjam</p>
        </div>

        <div class="bg-white border border-gray-200 p-5 rounded-sm">
            <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Anggota Aktif</p>
            <h3 class="text-3xl font-light text-gray-900 mt-2">{{ $totalMembers }}</h3>
            <p class="text-xs text-gray-400 mt-2">Terdaftar</p>
        </div>

        <div class="bg-white border border-gray-200 p-5 rounded-sm">
            <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Sedang Dipinjam</p>
            <h3 class="text-3xl font-light text-gray-900 mt-2">{{ $activeLoans }}</h3>
            <p class="text-xs text-gray-400 mt-2">Transaksi Aktif</p>
        </div>

        <div class="bg-white border border-gray-200 p-5 rounded-sm">
            <p class="text-xs uppercase tracking-wider text-gray-500 font-medium">Denda Belum Lunas</p>
            <h3 class="text-3xl font-light text-gray-900 mt-2">Rp {{ number_format($unpaidFines, 0, ',', '.') }}</h3>
            <p class="text-xs text-red-500 mt-2">Tunggakan</p>
        </div>

    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white border border-gray-200 rounded-sm">
        <div class="px-5 py-4 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-sm font-medium text-gray-900">Transaksi Terbaru</h3>
            <a href="#" class="text-xs text-gray-500 hover:text-black border-b border-gray-300 hover:border-black">Lihat Semua</a>
        </div>
        <div class="p-5">
            @if($recentLoans->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase border-b border-gray-200">
                        <tr>
                            <th class="py-3 px-2 font-medium">Kode</th>
                            <th class="py-3 px-2 font-medium">Anggota</th>
                            <th class="py-3 px-2 font-medium">Tgl Pinjam</th>
                            <th class="py-3 px-2 font-medium">Batas Kembali</th>
                            <th class="py-3 px-2 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentLoans as $loan)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-2 font-mono text-xs">{{ $loan->kode_pinjam }}</td>
                            <td class="py-3 px-2 text-gray-800">{{ $loan->member->nama }}</td>
                            <td class="py-3 px-2 text-gray-600">{{ $loan->tanggal_pinjam->format('d M Y') }}</td>
                            <td class="py-3 px-2 text-gray-600">{{ $loan->tanggal_kembali->format('d M Y') }}</td>
                            <td class="py-3 px-2">
                                <span class="px-2 py-1 text-xs {{ $loan->status == 'dipinjam' ? 'bg-blue-50 text-blue-600' : 'bg-green-50 text-green-600' }}">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="text-sm text-gray-400 text-center py-4">Belum ada transaksi terbaru.</p>
            @endif
        </div>
    </div>

</div>
@endsection