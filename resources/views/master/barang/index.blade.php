@extends('layouts.app')

@section('content')
<div class="animate-fadeIn space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i data-lucide="package" class="w-6 h-6 text-blue-500"></i>
            Master Barang
        </h2>

        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto items-center">
            {{-- Form Pencarian --}}
            <form action="{{ route('barang.index') }}" method="GET" class="flex items-center bg-white rounded-lg shadow-sm border px-3 py-2 w-full sm:w-64">
                <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari barang..." 
                       class="ml-2 w-full outline-none text-sm text-gray-700 bg-transparent">
            </form>

            {{-- Tombol Tambah --}}
            <a href="{{ route('barang.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                <i data-lucide="plus-circle" class="w-5 h-5"></i> Tambah Barang
            </a>
        </div>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="p-3 rounded-md bg-green-100 text-green-800 text-sm border border-green-300 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tabel Data Barang --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 border-b text-gray-700">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-center w-12">No</th>
                        <th class="px-4 py-3 font-semibold">Kode</th>
                        <th class="px-4 py-3 font-semibold">Nama Barang</th>
                        <th class="px-4 py-3 font-semibold">Kategori</th>
                        <th class="px-4 py-3 font-semibold">Merk</th>
                        <th class="px-4 py-3 font-semibold">Satuan</th>
                        <th class="px-4 py-3 font-semibold text-center">Stok</th>
                        <th class="px-4 py-3 font-semibold text-center">Min. Stok</th>
                        <th class="px-4 py-3 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $index => $row)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2 text-center text-gray-600">
                                {{ $barang->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-2 font-medium text-gray-800">{{ $row->kode }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $row->nama }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $row->kategori->nama ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $row->merk->nama ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $row->satuan->nama ?? '-' }}</td>
                            <td class="px-4 py-2 text-center font-semibold text-blue-600">{{ $row->stock ?? 0 }}</td>
                            <td class="px-4 py-2 text-center text-gray-600">{{ $row->min_stock ?? 0 }}</td>
                            <td class="px-4 py-2 text-center flex justify-center gap-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('barang.edit', $row->id) }}"
                                   class="inline-flex items-center justify-center p-2 bg-yellow-400/80 hover:bg-yellow-500 text-white rounded-md transition"
                                   title="Edit Barang">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('barang.destroy', $row->id) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin menghapus barang ini?')" 
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center p-2 bg-red-500/80 hover:bg-red-600 text-white rounded-md transition"
                                            title="Hapus Barang">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-4 py-4 text-center text-gray-500 italic">
                                Belum ada data barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t flex justify-between items-center">
            <p class="text-sm text-gray-500">
                Menampilkan {{ $barang->firstItem() ?? 0 }} - {{ $barang->lastItem() ?? 0 }} dari {{ $barang->total() }} data
            </p>
            <div>
                {{ $barang->appends(['search' => request('search')])->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection
