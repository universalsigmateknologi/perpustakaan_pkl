<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard Admin — Perpustakaan')</title>

    <!-- Tailwind CSS CDN -->
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --scrollbar-thumb: #d1d5db;
            --scrollbar-track: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: var(--scrollbar-thumb);
            border-radius: 9999px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        .smooth-transition {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .focus-ring-minimal:focus {
            outline: none;
            ring: 2px solid #e2e6eb;
            ring-offset: 2px;
        }

        @media print {
            .no-print { display: none !important; }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-white text-brand-900 font-sans antialiased h-screen overflow-hidden">

    <div class="flex h-full">

        <!-- ==================== SIDEBAR ==================== -->
        <aside class="no-print w-60 flex-shrink-0 h-full bg-white border-r border-brand-100 flex flex-col z-20">
            <!-- Logo -->
            <div class="flex items-center gap-3 px-6 h-16 border-b border-brand-100 flex-shrink-0">
                <div class="w-8 h-8 flex items-center justify-center flex-shrink-0">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"
                         stroke-linecap="round" stroke-linejoin="round" class="w-7 h-7 text-brand-900">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5A2.5 2.5 0 0 1 4 19.5Z"/>
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <line x1="8" y1="7" x2="14" y2="7"/>
                        <line x1="8" y1="11" x2="12" y2="11"/>
                    </svg>
                </div>
                <span class="text-base font-semibold tracking-tight text-brand-900 whitespace-nowrap">Perpustakaan</span>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto custom-scrollbar py-5 px-4 space-y-0.5" aria-label="Sidebar Navigation">
                {{-- Dashboard --}}
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-brand-50 text-brand-900' : 'text-brand-500 hover:text-brand-900 hover:bg-brand-50' }} smooth-transition group"
                   aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round" class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-brand-600' : 'text-brand-400 group-hover:text-brand-600' }} flex-shrink-0 smooth-transition">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                {{-- Koleksi Buku --}}
                <a href=""
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('books.*') ? 'bg-brand-50 text-brand-900' : 'text-brand-500 hover:text-brand-900 hover:bg-brand-50' }} smooth-transition group">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round" class="w-5 h-5 {{ request()->routeIs('books.*') ? 'text-brand-600' : 'text-brand-400 group-hover:text-brand-600' }} flex-shrink-0 smooth-transition">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5Z"/>
                        <path d="M20 2v20"/>
                        <line x1="8" y1="7" x2="15" y2="7"/>
                        <line x1="8" y1="11" x2="13" y2="11"/>
                        <line x1="8" y1="15" x2="16" y2="15"/>
                    </svg>
                    <span>Koleksi Buku</span>
                </a>

                {{-- Anggota --}}
                <a href=""
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('members.*') ? 'bg-brand-50 text-brand-900' : 'text-brand-500 hover:text-brand-900 hover:bg-brand-50' }} smooth-transition group">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round" class="w-5 h-5 {{ request()->routeIs('members.*') ? 'text-brand-600' : 'text-brand-400 group-hover:text-brand-600' }} flex-shrink-0 smooth-transition">
                        <circle cx="9" cy="7" r="3"/>
                        <circle cx="18" cy="12" r="3"/>
                        <path d="M3 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/>
                        <path d="M14 21v-2a4 4 0 0 1 3-3.87"/>
                    </svg>
                    <span>Anggota</span>
                </a>

                {{-- Peminjaman --}}
                <a href=""
                   class="flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('loans.*') ? 'bg-brand-50 text-brand-900' : 'text-brand-500 hover:text-brand-900 hover:bg-brand-50' }} smooth-transition group">
                    <div class="flex items-center gap-3">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                             stroke-linejoin="round" class="w-5 h-5 {{ request()->routeIs('loans.*') ? 'text-brand-600' : 'text-brand-400 group-hover:text-brand-600' }} flex-shrink-0 smooth-transition">
                            <rect x="2" y="3" width="20" height="14" rx="2"/>
                            <line x1="8" y1="21" x2="16" y2="21"/>
                            <line x1="12" y1="17" x2="12" y2="21"/>
                        </svg>
                        <span>Peminjaman</span>
                    </div>
                    @php
                        $pendingLoans = 7; // bisa diambil dari controller
                    @endphp
                    @if($pendingLoans > 0)
                        <span class="inline-flex items-center justify-center h-5 min-w-[20px] px-1.5 text-[11px] font-semibold rounded-full bg-brand-900 text-white leading-none">
                            {{ $pendingLoans }}
                        </span>
                    @endif
                </a>

                {{-- Pengembalian --}}
                <a href=""
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('returns.*') ? 'bg-brand-50 text-brand-900' : 'text-brand-500 hover:text-brand-900 hover:bg-brand-50' }} smooth-transition group">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round" class="w-5 h-5 {{ request()->routeIs('returns.*') ? 'text-brand-600' : 'text-brand-400 group-hover:text-brand-600' }} flex-shrink-0 smooth-transition">
                        <polyline points="23 4 23 10 17 10"/>
                        <path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/>
                    </svg>
                    <span>Pengembalian</span>
                </a>

                {{-- Denda --}}
                <a href=""
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('fines.*') ? 'bg-brand-50 text-brand-900' : 'text-brand-500 hover:text-brand-900 hover:bg-brand-50' }} smooth-transition group">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round" class="w-5 h-5 {{ request()->routeIs('fines.*') ? 'text-brand-600' : 'text-brand-400 group-hover:text-brand-600' }} flex-shrink-0 smooth-transition">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="8" x2="12" y2="12"/>
                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                    </svg>
                    <span>Denda</span>
                </a>

                {{-- Laporan --}}
                <a href=""
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium {{ request()->routeIs('reports.*') ? 'bg-brand-50 text-brand-900' : 'text-brand-500 hover:text-brand-900 hover:bg-brand-50' }} smooth-transition group">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round" class="w-5 h-5 {{ request()->routeIs('reports.*') ? 'text-brand-600' : 'text-brand-400 group-hover:text-brand-600' }} flex-shrink-0 smooth-transition">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8Z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    <span>Laporan</span>
                </a>
            </nav>

            <!-- Bottom: Pengaturan -->
            <div class="flex-shrink-0 border-t border-brand-100 px-4 py-4">
                <a href=""
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium text-brand-500 hover:text-brand-900 hover:bg-brand-50 smooth-transition group">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                         stroke-linejoin="round" class="w-5 h-5 text-brand-400 group-hover:text-brand-600 flex-shrink-0 smooth-transition">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1Z"/>
                    </svg>
                    <span>Pengaturan</span>
                </a>
            </div>
        </aside>

        <!-- ==================== MAIN CONTENT ==================== -->
        <div class="flex-1 flex flex-col h-full overflow-hidden">

            <!-- ==================== TOP HEADER ==================== -->
            <header class="no-print flex-shrink-0 h-16 bg-white border-b border-brand-100 flex items-center justify-between px-8 z-10">
                <!-- Search -->
                <div class="relative w-full max-w-md">
                    <label for="search" class="sr-only">Cari buku, anggota, atau transaksi</label>
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-brand-400">
                            <circle cx="11" cy="11" r="8"/>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                    </div>
                    <input type="search" id="search" placeholder="Cari..."
                           class="block w-full pl-10 pr-4 py-2 text-sm border border-brand-200 rounded-lg bg-brand-50 text-brand-900 placeholder-brand-400
                                  focus:outline-none focus:border-brand-300 focus:bg-white focus:ring-1 focus:ring-brand-200 smooth-transition">
                </div>

                <!-- Right: Notif & Profile -->
                <div class="flex items-center gap-5">
                    <button type="button"
                            class="relative p-2 rounded-lg text-brand-500 hover:text-brand-900 hover:bg-brand-50 smooth-transition focus:outline-none focus:ring-2 focus:ring-brand-200"
                            aria-label="Notifikasi">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                             stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                        </svg>
                        <span class="absolute top-1.5 right-1.5 w-2.5 h-2.5 bg-brand-900 rounded-full border-2 border-white"></span>
                    </button>

                    <div class="w-px h-6 bg-brand-200"></div>

                    <!-- User Profile -->
                    <div class="relative" id="userMenuWrapper">
                        <button type="button" id="userMenuButton"
                                class="flex items-center gap-3 p-1.5 rounded-lg hover:bg-brand-50 smooth-transition focus:outline-none focus:ring-2 focus:ring-brand-200"
                                aria-label="Profil Pengguna" aria-expanded="false" aria-controls="userMenuDropdown">
                            <div class="w-8 h-8 rounded-full bg-brand-200 flex items-center justify-center text-xs font-semibold text-brand-600 flex-shrink-0">
                                {{ Auth::user()->initials ?? 'AD' }}
                            </div>
                            <div class="hidden sm:flex flex-col items-start text-left">
                                <span class="text-sm font-medium text-brand-900 leading-tight">{{ Auth::user()->name ?? 'Admin Dinda' }}</span>
                                <span class="text-xs text-brand-400 leading-tight">{{ Auth::user()->role ?? 'Administrator' }}</span>
                            </div>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                 stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 text-brand-400 hidden sm:block">
                                <polyline points="6 9 12 15 18 9"/>
                            </svg>
                        </button>

                        <div id="userMenuDropdown" class="hidden absolute right-0 mt-2 w-56 overflow-hidden rounded-xl border border-brand-200 bg-white py-2 shadow-lg z-50">
                            <div class="px-4 py-3 border-b border-brand-100">
                                <p class="text-sm font-semibold text-brand-900">{{ Auth::user()->name ?? 'Admin Dinda' }}</p>
                                <p class="text-xs text-brand-400">{{ Auth::user()->role ?? 'Administrator' }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="flex w-full items-center gap-2 px-4 py-2.5 text-sm text-brand-600 hover:bg-brand-50 hover:text-brand-900 smooth-transition">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                                         stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                        <polyline points="16 17 21 12 16 7"/>
                                        <line x1="21" y1="12" x2="9" y2="12"/>
                                    </svg>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- ==================== PAGE CONTENT ==================== -->
            <main class="flex-1 overflow-y-auto custom-scrollbar bg-brand-50/60">
                <div class="p-8 max-w-7xl mx-auto space-y-8">
                    {{-- Page Title & Breadcrumb --}}
                    <div>
                        <h1 class="text-2xl font-semibold text-brand-900 tracking-tight">@yield('page_title')</h1>
                        @hasSection('page_description')
                            <p class="text-sm text-brand-400 mt-0.5">@yield('page_description')</p>
                        @endif
                    </div>

                    {{-- Main content area --}}
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const wrapper = document.getElementById('userMenuWrapper');
            const button = document.getElementById('userMenuButton');
            const dropdown = document.getElementById('userMenuDropdown');

            if (!wrapper || !button || !dropdown) return;

            button.addEventListener('click', function (event) {
                event.stopPropagation();
                const isHidden = dropdown.classList.contains('hidden');
                dropdown.classList.toggle('hidden', !isHidden);
                button.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
            });

            document.addEventListener('click', function (event) {
                if (!wrapper.contains(event.target)) {
                    dropdown.classList.add('hidden');
                    button.setAttribute('aria-expanded', 'false');
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    dropdown.classList.add('hidden');
                    button.setAttribute('aria-expanded', 'false');
                }
            });
        });
    </script>
</body>
</html>