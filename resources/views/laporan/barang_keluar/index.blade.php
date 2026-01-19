@extends('layouts.app')

@section('content')
<div class="animate-fadeIn space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i data-lucide="file-diff" class="w-6 h-6 text-red-500"></i>
            Laporan Barang Keluar
        </h2>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('laporan.barang-keluar') }}"
          class="grid md:grid-cols-4 gap-4 bg-white p-4 rounded-xl shadow-sm">
        <div>
            <label class="block text-gray-700 text-sm font-medium mb-1">Dari Tanggal</label>
            <input type="date" name="from" value="{{ $from }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-medium mb-1">Sampai Tanggal</label>
            <input type="date" name="to" value="{{ $to }}"
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 px-3 py-2">
        </div>
        <div>
            <label class="block text-gray-700 text-sm font-medium mb-1">Pencarian</label>
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari barang / customer / user..."
                   class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 px-3 py-2">
        </div>
        <div class="flex items-end gap-2">
            <button class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all">
                <i data-lucide="search" class="w-5 h-5"></i> Tampilkan
            </button>
            <a href="{{ route('laporan.barang-keluar.pdf', ['from' => $from, 'to' => $to]) }}"
               target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 bg-gray-700 text-white rounded-lg hover:bg-gray-800 transition-all">
                <i data-lucide="file-text" class="w-5 h-5"></i> PDF
            </a>
        </div>
    </form>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 border-b text-gray-700">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-center w-16">No</th>
                        <th class="px-4 py-3 font-semibold">Tanggal</th>
                        <th class="px-4 py-3 font-semibold">Barang</th>
                        <th class="px-4 py-3 font-semibold">Customer</th>
                        <th class="px-4 py-3 font-semibold text-center">Qty</th>
                        <th class="px-4 py-3 font-semibold">Keterangan</th>
                        <th class="px-4 py-3 font-semibold">User</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $row)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2 text-center text-gray-600">
                                {{ $data->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-2 text-gray-700">
                                {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-2 text-gray-800 font-medium">{{ $row->barang->nama ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $row->customer->nama ?? '-' }}</td>
                            <td class="px-4 py-2 text-center font-semibold text-red-600">{{ $row->qty }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $row->keterangan ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $row->user->name ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500 italic">
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($data->hasPages())
        <div class="p-4 border-t flex flex-col sm:flex-row justify-between items-center gap-2">
            <p class="text-sm text-gray-500">
                Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} data
            </p>
            <div>
                {{ $data->appends(['search' => request('search'), 'from' => $from, 'to' => $to])->links('pagination::tailwind') }}
            </div>
        </div>
        @endif
    </div>
</div>

<script> lucide.createIcons(); </script>
@endsection
