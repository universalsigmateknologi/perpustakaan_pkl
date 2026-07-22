@extends('layouts.app')

@section('title', 'Dashboard — Perpustakaan')

@section('page_title', 'Dashboard')
@section('page_description', 'Ringkasan aktivitas perpustakaan hari ini.')

@section('content')
    <!-- ==================== STAT CARDS GRID ==================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Total Buku -->
        <div class="bg-white border border-brand-100 rounded-xl p-5 hover:border-brand-200 smooth-transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-brand-400 uppercase tracking-wider">Total Buku</span>
                <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center flex-shrink-0">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                         stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-brand-600">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5Z" />
                        <path d="M20 2v20" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-brand-900 tracking-tight">12.847</p>
            <p class="text-xs text-brand-400 mt-1">
                <span class="text-emerald-600 font-medium">↑ 124</span> bulan ini
            </p>
        </div>

        <!-- Card 2: Anggota Aktif -->
        <div class="bg-white border border-brand-100 rounded-xl p-5 hover:border-brand-200 smooth-transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-brand-400 uppercase tracking-wider">Anggota Aktif</span>
                <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center flex-shrink-0">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                         stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-brand-600">
                        <circle cx="9" cy="7" r="3" />
                        <path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-brand-900 tracking-tight">3.421</p>
            <p class="text-xs text-brand-400 mt-1">
                <span class="text-emerald-600 font-medium">↑ 56</span> minggu ini
            </p>
        </div>

        <!-- Card 3: Peminjaman Aktif -->
        <div class="bg-white border border-brand-100 rounded-xl p-5 hover:border-brand-200 smooth-transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-brand-400 uppercase tracking-wider">Dipinjam</span>
                <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center flex-shrink-0">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                         stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-brand-600">
                        <rect x="2" y="3" width="20" height="14" rx="2" />
                        <line x1="8" y1="21" x2="16" y2="21" />
                        <line x1="12" y1="17" x2="12" y2="21" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-brand-900 tracking-tight">287</p>
            <p class="text-xs text-brand-400 mt-1">
                <span class="text-amber-600 font-medium">7</span> terlambat
            </p>
        </div>

        <!-- Card 4: Denda Tertunggak -->
        <div class="bg-white border border-brand-100 rounded-xl p-5 hover:border-brand-200 smooth-transition group">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-medium text-brand-400 uppercase tracking-wider">Denda</span>
                <div class="w-8 h-8 rounded-lg bg-brand-50 flex items-center justify-center flex-shrink-0">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                         stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-brand-600">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                </div>
            </div>
            <p class="text-3xl font-bold text-brand-900 tracking-tight">Rp 245K</p>
            <p class="text-xs text-brand-400 mt-1">
                <span class="text-red-600 font-medium">↑ 18%</span> dari bulan lalu
            </p>
        </div>
    </div>

    <!-- ==================== CHART & TABLE SECTION ==================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        <!-- Mini Bar Chart: Statistik Peminjaman -->
        <div class="bg-white border border-brand-100 rounded-xl p-6 lg:col-span-1">
            <h3 class="text-sm font-semibold text-brand-900 mb-5">Peminjaman Harian</h3>
            <div class="flex items-end justify-between gap-2 h-40">
                <!-- Bar 1: Sen -->
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-brand-200 rounded-t-md smooth-transition hover:bg-brand-400 cursor-pointer"
                         style="height: 45%;" title="Senin: 18 pinjaman"></div>
                    <span class="text-[10px] text-brand-400 mt-2 font-medium">Sen</span>
                </div>
                <!-- Bar 2: Sel -->
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-brand-200 rounded-t-md smooth-transition hover:bg-brand-400 cursor-pointer"
                         style="height: 65%;" title="Selasa: 26 pinjaman"></div>
                    <span class="text-[10px] text-brand-400 mt-2 font-medium">Sel</span>
                </div>
                <!-- Bar 3: Rab -->
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-brand-200 rounded-t-md smooth-transition hover:bg-brand-400 cursor-pointer"
                         style="height: 78%;" title="Rabu: 31 pinjaman"></div>
                    <span class="text-[10px] text-brand-400 mt-2 font-medium">Rab</span>
                </div>
                <!-- Bar 4: Kam -->
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-brand-900 rounded-t-md smooth-transition hover:bg-brand-700 cursor-pointer"
                         style="height: 92%;" title="Kamis: 37 pinjaman"></div>
                    <span class="text-[10px] text-brand-400 mt-2 font-medium">Kam</span>
                </div>
                <!-- Bar 5: Jum -->
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-brand-200 rounded-t-md smooth-transition hover:bg-brand-400 cursor-pointer"
                         style="height: 58%;" title="Jumat: 23 pinjaman"></div>
                    <span class="text-[10px] text-brand-400 mt-2 font-medium">Jum</span>
                </div>
                <!-- Bar 6: Sab -->
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-brand-200 rounded-t-md smooth-transition hover:bg-brand-400 cursor-pointer"
                         style="height: 35%;" title="Sabtu: 14 pinjaman"></div>
                    <span class="text-[10px] text-brand-400 mt-2 font-medium">Sab</span>
                </div>
                <!-- Bar 7: Min -->
                <div class="flex flex-col items-center flex-1">
                    <div class="w-full bg-brand-200 rounded-t-md smooth-transition hover:bg-brand-400 cursor-pointer"
                         style="height: 20%;" title="Minggu: 8 pinjaman"></div>
                    <span class="text-[10px] text-brand-400 mt-2 font-medium">Min</span>
                </div>
            </div>
            <!-- Legend -->
            <div class="flex items-center gap-4 mt-5 pt-4 border-t border-brand-100">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-sm bg-brand-900"></div>
                    <span class="text-xs text-brand-500">Tertinggi</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 rounded-sm bg-brand-200"></div>
                    <span class="text-xs text-brand-500">Normal</span>
                </div>
            </div>
        </div>

        <!-- Recent Activity Table -->
        <div class="bg-white border border-brand-100 rounded-xl p-6 lg:col-span-2 overflow-hidden">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-sm font-semibold text-brand-900">Peminjaman Terbaru</h3>
                <a href="#" class="text-xs font-medium text-brand-500 hover:text-brand-900 smooth-transition">
                    Lihat Semua →
                </a>
            </div>

            <!-- Table Wrapper -->
            <div class="overflow-x-auto custom-scrollbar -mx-2">
                <table class="w-full min-w-[600px] text-sm">
                    <thead>
                        <tr class="border-b border-brand-100">
                            <th class="text-left py-3 px-3 text-xs font-semibold text-brand-400 uppercase tracking-wider">ID</th>
                            <th class="text-left py-3 px-3 text-xs font-semibold text-brand-400 uppercase tracking-wider">Judul Buku</th>
                            <th class="text-left py-3 px-3 text-xs font-semibold text-brand-400 uppercase tracking-wider">Peminjam</th>
                            <th class="text-left py-3 px-3 text-xs font-semibold text-brand-400 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="text-left py-3 px-3 text-xs font-semibold text-brand-400 uppercase tracking-wider">Status</th>
                            <th class="text-right py-3 px-3 text-xs font-semibold text-brand-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-brand-50">
                        <!-- Row 1 -->
                        <tr class="hover:bg-brand-50/50 smooth-transition group">
                            <td class="py-3 px-3 text-brand-400 font-mono text-xs">#PJ-001</td>
                            <td class="py-3 px-3 font-medium text-brand-900">Laut Bercerita</td>
                            <td class="py-3 px-3 text-brand-600">Rina Aulia</td>
                            <td class="py-3 px-3 text-brand-500">20 Jul 2026</td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Aktif
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <button class="text-xs font-medium text-brand-400 hover:text-brand-900 smooth-transition opacity-0 group-hover:opacity-100 focus:opacity-100">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr class="hover:bg-brand-50/50 smooth-transition group">
                            <td class="py-3 px-3 text-brand-400 font-mono text-xs">#PJ-002</td>
                            <td class="py-3 px-3 font-medium text-brand-900">Atomic Habits</td>
                            <td class="py-3 px-3 text-brand-600">Budi Santoso</td>
                            <td class="py-3 px-3 text-brand-500">19 Jul 2026</td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    Aktif
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <button class="text-xs font-medium text-brand-400 hover:text-brand-900 smooth-transition opacity-0 group-hover:opacity-100 focus:opacity-100">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr class="hover:bg-brand-50/50 smooth-transition group">
                            <td class="py-3 px-3 text-brand-400 font-mono text-xs">#PJ-003</td>
                            <td class="py-3 px-3 font-medium text-brand-900">Sapiens</td>
                            <td class="py-3 px-3 text-brand-600">Citra Dewi</td>
                            <td class="py-3 px-3 text-brand-500">18 Jul 2026</td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">
                                    Terlambat
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <button class="text-xs font-medium text-brand-400 hover:text-brand-900 smooth-transition opacity-0 group-hover:opacity-100 focus:opacity-100">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <!-- Row 4 -->
                        <tr class="hover:bg-brand-50/50 smooth-transition group">
                            <td class="py-3 px-3 text-brand-400 font-mono text-xs">#PJ-004</td>
                            <td class="py-3 px-3 font-medium text-brand-900">Filosofi Teras</td>
                            <td class="py-3 px-3 text-brand-600">Dedi Kurnia</td>
                            <td class="py-3 px-3 text-brand-500">17 Jul 2026</td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-100">
                                    H-1
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <button class="text-xs font-medium text-brand-400 hover:text-brand-900 smooth-transition opacity-0 group-hover:opacity-100 focus:opacity-100">
                                    Detail
                                </button>
                            </td>
                        </tr>
                        <!-- Row 5 -->
                        <tr class="hover:bg-brand-50/50 smooth-transition group">
                            <td class="py-3 px-3 text-brand-400 font-mono text-xs">#PJ-005</td>
                            <td class="py-3 px-3 font-medium text-brand-900">Dilan 1990</td>
                            <td class="py-3 px-3 text-brand-600">Eka Putri</td>
                            <td class="py-3 px-3 text-brand-500">16 Jul 2026</td>
                            <td class="py-3 px-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-50 text-gray-600 border border-gray-100">
                                    Kembali
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <button class="text-xs font-medium text-brand-400 hover:text-brand-900 smooth-transition opacity-0 group-hover:opacity-100 focus:opacity-100">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ==================== QUICK STATS ROW ==================== -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- Buku Terpopuler -->
        <div class="bg-white border border-brand-100 rounded-xl p-5">
            <h4 class="text-xs font-semibold text-brand-400 uppercase tracking-wider mb-3">Buku Terpopuler</h4>
            <ol class="space-y-2.5">
                <li class="flex items-center justify-between text-sm">
                    <span class="text-brand-900 font-medium truncate mr-2">1. Laut Bercerita</span>
                    <span class="text-brand-400 text-xs flex-shrink-0">142x</span>
                </li>
                <li class="flex items-center justify-between text-sm">
                    <span class="text-brand-900 font-medium truncate mr-2">2. Atomic Habits</span>
                    <span class="text-brand-400 text-xs flex-shrink-0">128x</span>
                </li>
                <li class="flex items-center justify-between text-sm">
                    <span class="text-brand-900 font-medium truncate mr-2">3. Filosofi Teras</span>
                    <span class="text-brand-400 text-xs flex-shrink-0">97x</span>
                </li>
            </ol>
        </div>

        <!-- Kategori Koleksi -->
        <div class="bg-white border border-brand-100 rounded-xl p-5">
            <h4 class="text-xs font-semibold text-brand-400 uppercase tracking-wider mb-3">Kategori Koleksi</h4>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-brand-700">Fiksi</span>
                        <span class="text-brand-400 font-medium">45%</span>
                    </div>
                    <div class="w-full h-1.5 bg-brand-100 rounded-full overflow-hidden">
                        <div class="h-full bg-brand-900 rounded-full" style="width: 45%;"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-brand-700">Non-Fiksi</span>
                        <span class="text-brand-400 font-medium">30%</span>
                    </div>
                    <div class="w-full h-1.5 bg-brand-100 rounded-full overflow-hidden">
                        <div class="h-full bg-brand-600 rounded-full" style="width: 30%;"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-brand-700">Referensi</span>
                        <span class="text-brand-400 font-medium">15%</span>
                    </div>
                    <div class="w-full h-1.5 bg-brand-100 rounded-full overflow-hidden">
                        <div class="h-full bg-brand-400 rounded-full" style="width: 15%;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jam Operasional -->
        <div class="bg-white border border-brand-100 rounded-xl p-5 flex flex-col justify-between">
            <h4 class="text-xs font-semibold text-brand-400 uppercase tracking-wider mb-3">Jam Layanan</h4>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-brand-500">Senin - Jumat</span>
                    <span class="text-brand-900 font-medium">08:00 – 18:00</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-brand-500">Sabtu</span>
                    <span class="text-brand-900 font-medium">09:00 – 15:00</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-brand-500">Minggu</span>
                    <span class="text-brand-400">Tutup</span>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-brand-100">
                <span class="inline-flex items-center gap-1.5 text-xs font-medium text-emerald-700">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                    Sedang Buka
                </span>
            </div>
        </div>
    </div>

    <!-- ==================== FOOTER NOTE ==================== -->
    <footer class="text-center text-xs text-brand-300 pt-2 pb-4">
        &copy; 2026 Perpustakaan — Admin Panel. Seluruh data bersifat simulasi.
    </footer>
@endsection