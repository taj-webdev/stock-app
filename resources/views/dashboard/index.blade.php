@extends('layouts.app')

@section('content')
{{-- 🔹 Loader Dashboard (muncul sekali saat pertama kali masuk) --}}
<div id="dashboardLoader" class="fixed inset-0 z-[10000] bg-white/95 backdrop-blur-sm flex flex-col items-center justify-center transition-all duration-700">
    <div class="relative">
        <div class="w-14 h-14 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
        <div class="absolute inset-0 flex items-center justify-center">
            <i data-lucide="loader-2" class="w-6 h-6 text-blue-600 animate-pulse"></i>
        </div>
    </div>
    <p class="mt-4 text-gray-700 font-semibold animate-pulse">Memuat Dashboard...</p>
</div>

{{-- 🔹 Konten Dashboard --}}
<div id="dashboardContent" class="space-y-8 opacity-0 scale-[0.98] transition-all duration-700 ease-out min-h-[calc(100vh-160px)] overflow-x-hidden">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i data-lucide="layout-dashboard" class="w-6 h-6 text-blue-500"></i> Dashboard
            </h2>
            <p class="text-sm text-gray-500">Ringkasan aktivitas stok dan performa barang</p>
        </div>
        <div class="text-sm text-gray-500">Data real-time dari database</div>
    </div>

    {{-- Statistik Cards (gradient + sparkline) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $cards = [
                [
                    'title' => 'Total Barang',
                    'value' => $totalBarang,
                    'pct'   => $pctBarang,
                    'trend' => $barangTrend,
                    'months'=> $months,
                    'icon'  => 'package',
                    'gradient' => 'from-indigo-500 to-indigo-400'
                ],
                [
                    'title' => 'Customers',
                    'value' => $totalCustomer,
                    'pct'   => $pctCustomer,
                    'trend' => $customerTrend,
                    'months'=> $months,
                    'icon'  => 'users',
                    'gradient' => 'from-emerald-400 to-emerald-300'
                ],
                [
                    'title' => 'Total Masuk',
                    'value' => $totalMasuk,
                    'pct'   => $pctMasuk,
                    'trend' => $masukTrend,
                    'months'=> $months,
                    'icon'  => 'download',
                    'gradient' => 'from-sky-400 to-cyan-300'
                ],
                [
                    'title' => 'Total Keluar',
                    'value' => $totalKeluar,
                    'pct'   => $pctKeluar,
                    'trend' => $keluarTrend,
                    'months'=> $months,
                    'icon'  => 'upload',
                    'gradient' => 'from-rose-500 to-rose-300'
                ],
            ];
        @endphp

        @foreach ($cards as $i => $c)
        <div class="relative rounded-xl overflow-hidden shadow-lg transform hover:scale-[1.02] transition-all duration-300">
            <div class="p-5 bg-gradient-to-br {{ $c['gradient'] }} text-white relative">
                <div class="absolute inset-0 opacity-10 pointer-events-none bg-[url('https://www.transparenttextures.com/patterns/asfalt-light.png')] bg-[length:300px]"></div>

                <div class="flex items-start justify-between relative z-10">
                    <div>
                        <div class="text-sm opacity-90">{{ $c['title'] }}</div>
                        <div class="text-3xl font-bold mt-1">{{ $c['value'] }}</div>
                        <div class="mt-2 text-xs flex items-center gap-2">
                            @if($c['pct'] >= 0)
                                <span class="inline-flex items-center text-green-100">
                                    <i data-lucide="trending-up" class="w-4 h-4"></i>
                                    {{ abs($c['pct']) }}%
                                </span>
                            @else
                                <span class="inline-flex items-center text-red-100">
                                    <i data-lucide="trending-down" class="w-4 h-4"></i>
                                    {{ abs($c['pct']) }}%
                                </span>
                            @endif
                            <span class="opacity-80">dari bulan lalu</span>
                        </div>
                    </div>
                    <div class="text-white/70">
                        <div class="bg-white/20 p-2 rounded-lg">
                            <i data-lucide="{{ $c['icon'] }}" class="w-6 h-6"></i>
                        </div>
                    </div>
                </div>

                {{-- Sparkline Mini Chart --}}
                <div class="mt-4 relative z-10 h-[50px]">
                    <canvas id="spark-{{ $i }}"></canvas>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- 🔹 Charts Area (auto height, no extra scroll) --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pb-6">
        {{-- Chart stok barang --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <i data-lucide="bar-chart-2" class="w-5 h-5 text-blue-500"></i> Statistik Stok Barang
            </h5>
            <div class="h-[320px]">
                <canvas id="stokChart"></canvas>
            </div>
        </div>

        {{-- Chart aktivitas & top barang --}}
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <i data-lucide="activity" class="w-5 h-5 text-green-500"></i> Aktivitas Stok Barang ({{ date('Y') }})
                </h5>
                <div class="h-[260px]">
                    <canvas id="aktivitasChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h5 class="text-lg font-semibold text-gray-700 mb-3 flex items-center gap-2">
                    <i data-lucide="award" class="w-5 h-5 text-yellow-500"></i> Top 5 Barang Terlaris
                </h5>
                <div class="h-[240px]">
                    <canvas id="topBarangChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 🔹 Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    lucide.createIcons();

    const loader = document.getElementById('dashboardLoader');
    const content = document.getElementById('dashboardContent');

    // Loader hanya muncul sekali setelah login
    const loaded = localStorage.getItem('dashboardLoaded');
    if (!loaded) {
        setTimeout(() => {
            loader.classList.add('opacity-0', 'scale-105');
            setTimeout(() => {
                loader.style.display = 'none';
                content.classList.remove('opacity-0', 'scale-[0.98]');
                localStorage.setItem('dashboardLoaded', 'true');
            }, 500);
        }, 900);
    } else {
        loader.style.display = 'none';
        content.classList.remove('opacity-0', 'scale-[0.98]');
    }

    // === Sparkline charts ===
    const sparkData = [
        @foreach ($cards as $i => $c)
            { data: @json(array_values($c['trend'])) }@if($i < count($cards)-1),@endif
        @endforeach
    ];

    sparkData.forEach((s, idx) => {
        const ctx = document.getElementById('spark-' + idx).getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($months),
                datasets: [{
                    data: s.data,
                    borderWidth: 2,
                    fill: false,
                    tension: 0.3,
                    borderColor: '#ffffff',
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false }, tooltip: { enabled: false } },
                scales: { x: { display: false }, y: { display: false } }
            }
        });
    });

    // === Stok Chart (Bar) ===
    const stokLabels = @json($barangLabels);
    const stokValues = @json($barangStok);
    const stokColors = stokLabels.map((_, i) => `hsl(${Math.random()*360} 70% 55%)`);

    new Chart(document.getElementById('stokChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: stokLabels,
            datasets: [{
                label: 'Stok',
                data: stokValues,
                backgroundColor: stokColors,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false }, title: { display: true, text: 'Top 10 Barang (Stok)' } },
            scales: { y: { beginAtZero: true } },
            animation: { duration: 1000, easing: 'easeOutQuart' }
        }
    });

    // === Aktivitas (Line Chart) ===
    new Chart(document.getElementById('aktivitasChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: @json($bulanLabels),
            datasets: [
                {
                    label: 'Masuk',
                    data: @json($masukData),
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16,185,129,0.18)',
                    tension: 0.3,
                    fill: true
                },
                {
                    label: 'Keluar',
                    data: @json($keluarData),
                    borderColor: '#EF4444',
                    backgroundColor: 'rgba(239,68,68,0.18)',
                    tension: 0.3,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: true } },
            scales: { y: { beginAtZero: true } },
            animation: { duration: 1000, easing: 'easeInOutSine' }
        }
    });

    // === Top Barang (Pie) ===
    new Chart(document.getElementById('topBarangChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: @json($topLabels),
            datasets: [{
                data: @json($topValues),
                backgroundColor: ['#3B82F6','#10B981','#EAB308','#EF4444','#8B5CF6'],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'right' } },
            animation: { duration: 1200, easing: 'easeOutBack' }
        }
    });
});
</script>
@endsection
