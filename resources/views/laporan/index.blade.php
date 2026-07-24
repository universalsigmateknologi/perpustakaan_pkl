@extends('layouts.app')

@section('title', 'Menu Laporan')
@section('header_title', 'Modul Laporan Sistem')

@section('content')
<div class="space-y-6">
    
    <div>
        <h2 class="text-lg font-medium text-gray-900">Pilih Jenis Laporan</h2>
        <p class="text-sm text-gray-500">Pilih laporan yang ingin Anda lihat atau cetak.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- Kartu Laporan Buku -->
        <a href="{{ route('admin.reports.books') }}" class="bg-white border border-gray-200 p-6 rounded-sm hover:border-black transition-colors group">
            <div class="flex flex-col h-full">
                <h3 class="text-base font-medium text-gray-900 mb-2">Laporan Data Buku</h3>
                <p class="text-sm text-gray-500 flex-1">Rekapitulasi stok buku (Total stok vs stok tersedia).</p>
                <span class="mt-4 text-xs text-black font-medium group-hover:underline">Lihat Laporan &rarr;</span>
            </div>
        </a>

        <!-- Kartu Laporan Transaksi -->
        <a href="{{ route('admin.reports.transactions') }}" class="bg-white border border-gray-200 p-6 rounded-sm hover:border-black transition-colors group">
            <div class="flex flex-col h-full">
                <h3 class="text-base font-medium text-gray-900 mb-2">Laporan Transaksi</h3>
                <p class="text-sm text-gray-500 flex-1">History peminjaman & pengembalian dengan filter rentang tanggal.</p>
                <span class="mt-4 text-xs text-black font-medium group-hover:underline">Lihat Laporan &rarr;</span>
            </div>
        </a>

        <!-- Kartu Laporan Denda -->
        <a href="{{ route('admin.reports.fines') }}" class="bg-white border border-gray-200 p-6 rounded-sm hover:border-black transition-colors group">
            <div class="flex flex-col h-full">
                <h3 class="text-base font-medium text-gray-900 mb-2">Laporan Keuangan Denda</h3>
                <p class="text-sm text-gray-500 flex-1">Rekap pemasukan denda yang sudah lunas dengan filter tanggal.</p>
                <span class="mt-4 text-xs text-black font-medium group-hover:underline">Lihat Laporan &rarr;</span>
            </div>
        </a>

    </div>
</div>
@endsection