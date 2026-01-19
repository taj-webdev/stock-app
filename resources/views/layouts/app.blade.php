<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }} - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- TailwindCSS & Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')

    {{-- Lucide & SweetAlert2 --}}
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        html { scroll-behavior: smooth; }
        summary::-webkit-details-marker { display: none; }

        details[open] div {
            animation: dropdownOpen 0.35s ease forwards;
        }
        @keyframes dropdownOpen {
            from { opacity: 0; transform: translateY(-6px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .spinner {
            border: 4px solid rgba(0,0,0,0.1);
            border-left-color: #2563eb;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            animation: spin 0.9s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Global fade animation */
        #pageContent {
            opacity: 0;
            transform: translateY(8px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        #pageContent.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Global Loaders */
        #logoutLoader, #pageLoader {
            position: fixed;
            inset: 0;
            display: none;
            justify-content: center;
            align-items: center;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(6px);
            animation: fadeIn 0.4s ease forwards;
        }
        #logoutLoader { z-index: 9999; }
        #pageLoader { z-index: 9998; }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    </style>
</head>

<body class="bg-gray-100 font-sans text-gray-800 flex min-h-screen">

    {{-- 🔹 LOGOUT LOADER --}}
    <div id="logoutLoader">
        <div class="flex flex-col items-center space-y-3">
            <div class="spinner"></div>
            <p class="text-gray-700 font-semibold animate-pulse">Sedang Keluar...</p>
        </div>
    </div>

    {{-- 🔹 PAGE LOADER GLOBAL --}}
    <div id="pageLoader">
        <div class="flex flex-col items-center space-y-3">
            <div class="spinner"></div>
            <p class="text-gray-700 font-semibold animate-pulse">Memuat Halaman...</p>
        </div>
    </div>

    {{-- 🔹 SIDEBAR --}}
    <aside class="w-64 bg-gray-900 text-gray-300 flex flex-col fixed h-full shadow-xl">
        <div class="p-5 border-b border-gray-800 flex items-center gap-2">
            <i data-lucide="package" class="w-5 h-5 text-blue-400"></i>
            <h1 class="text-lg font-semibold text-white">{{ config('app.name') }}</h1>
        </div>

        <nav class="flex-1 overflow-y-auto p-4 space-y-2">
            <a href="{{ route('dashboard') }}" 
               class="menu-link flex items-center gap-2 px-3 py-2 rounded-md transition-all duration-200 
               {{ request()->is('dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Dashboard
            </a>

            <details class="group">
                <summary class="flex items-center justify-between px-3 py-2 cursor-pointer rounded-md hover:bg-gray-800 transition-all duration-200">
                    <span class="flex items-center gap-2"><i data-lucide="box" class="w-5 h-5"></i> Master Barang</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 group-open:rotate-180 transition-transform duration-300"></i>
                </summary>
                <div class="pl-8 mt-2 space-y-2 text-sm">
                    <a href="{{ route('barang.index') }}" class="menu-link flex items-center gap-2 hover:text-blue-400 {{ request()->is('master/barang*') ? 'text-blue-400' : '' }}">
                        <i data-lucide="package" class="w-4 h-4"></i> Barang
                    </a>
                    <a href="{{ route('kategori.index') }}" class="menu-link flex items-center gap-2 hover:text-blue-400 {{ request()->is('master/kategori*') ? 'text-blue-400' : '' }}">
                        <i data-lucide="tags" class="w-4 h-4"></i> Kategori
                    </a>
                    <a href="{{ route('merk.index') }}" class="menu-link flex items-center gap-2 hover:text-blue-400 {{ request()->is('master/merk*') ? 'text-blue-400' : '' }}">
                        <i data-lucide="building" class="w-4 h-4"></i> Merk
                    </a>
                    <a href="{{ route('satuan.index') }}" class="menu-link flex items-center gap-2 hover:text-blue-400 {{ request()->is('master/satuan*') ? 'text-blue-400' : '' }}">
                        <i data-lucide="layers" class="w-4 h-4"></i> Satuan
                    </a>
                </div>
            </details>

            <a href="{{ route('customers.index') }}" 
               class="menu-link flex items-center gap-2 px-3 py-2 rounded-md transition-all duration-200 
               {{ request()->is('customers*') ? 'bg-blue-600 text-white' : 'hover:bg-gray-800 hover:text-white' }}">
                <i data-lucide="users" class="w-5 h-5"></i> Customers
            </a>

            <details class="group">
                <summary class="flex items-center justify-between px-3 py-2 cursor-pointer rounded-md hover:bg-gray-800 transition-all duration-200">
                    <span class="flex items-center gap-2"><i data-lucide="refresh-ccw" class="w-5 h-5"></i> Transaksi</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 group-open:rotate-180 transition-transform duration-300"></i>
                </summary>
                <div class="pl-8 mt-2 space-y-2 text-sm">
                    <a href="{{ route('barang-masuk.index') }}" class="menu-link flex items-center gap-2 hover:text-blue-400 {{ request()->is('barang-masuk*') ? 'text-blue-400' : '' }}">
                        <i data-lucide="download" class="w-4 h-4"></i> Barang Masuk
                    </a>
                    <a href="{{ route('barang-keluar.index') }}" class="menu-link flex items-center gap-2 hover:text-blue-400 {{ request()->is('barang-keluar*') ? 'text-blue-400' : '' }}">
                        <i data-lucide="upload" class="w-4 h-4"></i> Barang Keluar
                    </a>
                </div>
            </details>

            <details class="group">
                <summary class="flex items-center justify-between px-3 py-2 cursor-pointer rounded-md hover:bg-gray-800 transition-all duration-200">
                    <span class="flex items-center gap-2"><i data-lucide="file-text" class="w-5 h-5"></i> Laporan</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 group-open:rotate-180 transition-transform duration-300"></i>
                </summary>
                <div class="pl-8 mt-2 space-y-2 text-sm">
                    <a href="{{ route('laporan.barang-masuk') }}" class="menu-link flex items-center gap-2 hover:text-blue-400 {{ request()->is('laporan/barang-masuk*') ? 'text-blue-400' : '' }}">
                        <i data-lucide="file-input" class="w-4 h-4"></i> Barang Masuk
                    </a>
                    <a href="{{ route('laporan.barang-keluar') }}" class="menu-link flex items-center gap-2 hover:text-blue-400 {{ request()->is('laporan/barang-keluar*') ? 'text-blue-400' : '' }}">
                        <i data-lucide="file-output" class="w-4 h-4"></i> Barang Keluar
                    </a>
                </div>
            </details>
        </nav>

        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="p-4 border-t border-gray-800">
            @csrf
            <button type="button" id="logoutBtn" class="flex items-center gap-2 w-full px-3 py-2 rounded-md text-red-400 hover:bg-gray-800 transition-all duration-200">
                <i data-lucide="log-out" class="w-5 h-5"></i> Logout
            </button>
        </form>
    </aside>

    {{-- MAIN CONTENT --}}
    <main class="flex-1 ml-64 p-6">
        <header class="bg-white shadow-sm rounded-lg px-5 py-3 mb-6 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <i data-lucide="hand" class="w-6 h-6 text-yellow-500 animate-wiggle"></i>
                <div>
                    <h2 class="text-gray-700 text-lg font-semibold flex items-center gap-1">
                        Hai, <span class="text-blue-600">{{ Auth::user()->name }}</span> 👋
                    </h2>
                    <p class="text-xs text-gray-500">({{ ucfirst(Auth::user()->role) }})</p>
                </div>
            </div>
            <div class="text-right">
                <span id="clock" class="font-semibold text-gray-700 text-sm"></span>
            </div>
        </header>

        <section id="pageContent">
            @yield('content')
        </section>

        <footer class="text-center text-sm text-gray-500 mt-10">
            © {{ date('Y') }} <strong>Stock App</strong> — Sistem Manajemen Stok Barang
        </footer>
    </main>

    <script>
        lucide.createIcons();

        // Clock
        function updateClock() {
            const now = new Date();
            document.getElementById('clock').innerText = now.toLocaleTimeString('id-ID', { hour12: false });
        }
        setInterval(updateClock, 1000);
        updateClock();

        // Fade-in global
        window.addEventListener('DOMContentLoaded', () => {
            const content = document.getElementById('pageContent');
            setTimeout(() => content.classList.add('visible'), 400);
        });

        // Global Page Loader
        const pageLoader = document.getElementById('pageLoader');
        const menuLinks = document.querySelectorAll('.menu-link');
        const content = document.getElementById('pageContent');

        menuLinks.forEach(link => {
            link.addEventListener('click', e => {
                const url = link.getAttribute('href');
                if (url && url !== window.location.href && !url.includes('/dashboard')) {
                    e.preventDefault();
                    content.classList.remove('visible');
                    setTimeout(() => {
                        pageLoader.style.display = 'flex';
                        setTimeout(() => window.location.href = url, 700);
                    }, 400);
                }
            });
        });

        // Loader aktif saat reload/back kecuali dashboard
        window.addEventListener('beforeunload', e => {
            if (!document.activeElement.classList.contains('swal2-confirm') && !window.location.pathname.includes('/dashboard')) {
                pageLoader.style.display = 'flex';
            }
        });

        // Logout Spinner
        document.getElementById('logoutBtn').addEventListener('click', () => {
            Swal.fire({
                title: 'Yakin ingin logout?',
                text: "Sesi kamu akan diakhiri.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#2563eb',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, logout',
                cancelButtonText: 'Batal'
            }).then((r) => {
                if (r.isConfirmed) {
                    document.getElementById('logoutLoader').style.display = 'flex';
                    setTimeout(() => document.getElementById('logoutForm').submit(), 1500);
                }
            });
        });
    </script>
</body>
</html>
