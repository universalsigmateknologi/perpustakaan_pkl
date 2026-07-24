@extends('layouts.app')

@section('title', 'Laporan Transaksi')
@section('header_title', 'Laporan Peminjaman & Pengembalian')

@section('content')
<div class="space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <a href="{{ route('admin.reports.index') }}" class="text-xs text-gray-500 hover:text-black">&larr; Menu Laporan</a>
            <h2 class="text-lg font-medium text-gray-900 mt-2">History Transaksi</h2>
        </div>
    </div>

    <!-- Filter Tanggal -->
    <div class="bg-white border border-gray-200 p-4 rounded-sm">
        <form action="{{ route('admin.reports.transactions') }}" method="GET" class="flex flex-col md:flex-row md:items-end gap-4">
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" required class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm focus:border-black">
            </div>
            <div class="flex-1">
                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" required class="w-full px-0 py-1.5 bg-transparent border-0 border-b border-gray-300 text-sm focus:border-black">
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-gray-100 text-gray-800 py-2 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-200">Filter</button>
                <a href="{{ route('admin.reports.transactions.pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" target="_blank" class="bg-white border border-gray-300 text-gray-700 py-2 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-50">PDF</a>
                <a href="{{ route('admin.reports.transactions.excel', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="bg-white border border-gray-300 text-gray-700 py-2 px-5 text-xs uppercase tracking-widest font-medium hover:bg-gray-50">Excel</a>
            </div>
        </form>
    </div>

    <!-- Tabel -->
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
                        <td class="py-3 px-4 font-mono text-xs">{{ $loan->kode_pinjam }}</td>
                        <td class="py-3 px-4 text-gray-900">{{ $loan->member->nama }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d M Y') }}</td>
                        <td class="py-3 px-4 text-gray-600">{{ \Carbon\Carbon::parse($loan->tanggal_kembali)->format('d M Y') }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-1 text-xs {{ $loan->status == 'dipinjam' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700' }}">{{ ucfirst($loan->status) }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="py-6 text-center text-sm text-gray-400">Tidak ada transaksi pada rentang tanggal ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection