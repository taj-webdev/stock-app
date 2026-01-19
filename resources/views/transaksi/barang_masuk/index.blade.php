@extends('layouts.app')

@section('content')
<div class="animate-fadeIn space-y-6">

    {{-- Header + Search --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i data-lucide="package-plus" class="w-6 h-6 text-blue-500"></i>
            Transaksi Barang Masuk
        </h2>

        <form action="{{ route('barang-masuk.index') }}" method="GET"
              class="flex items-center bg-white rounded-lg shadow-sm border px-3 py-2 w-full sm:w-80">
            <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari barang / tanggal / keterangan..."
                   class="ml-2 w-full outline-none text-sm text-gray-700 bg-transparent">
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="p-3 rounded-md bg-green-100 text-green-800 text-sm border border-green-300 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tombol Tambah --}}
    <div>
        <a href="{{ route('barang-masuk.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-sm">
            <i data-lucide="plus-circle" class="w-5 h-5"></i> Tambah Transaksi
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 border-b text-gray-700">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-center w-16">No</th>
                        <th class="px-4 py-3 font-semibold">Tanggal</th>
                        <th class="px-4 py-3 font-semibold">Barang</th>
                        <th class="px-4 py-3 font-semibold text-center">Qty</th>
                        <th class="px-4 py-3 font-semibold">Keterangan</th>
                        <th class="px-4 py-3 font-semibold">User</th>
                        <th class="px-4 py-3 font-semibold text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $row)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2 text-center text-gray-600">
                                {{ $data->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-2 text-gray-800">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-2 text-gray-700">{{ $row->barang->nama ?? '-' }}</td>
                            <td class="px-4 py-2 text-center font-semibold text-blue-600">{{ $row->qty }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $row->keterangan ?? '-' }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $row->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 text-center flex justify-center gap-2">
                                {{-- Edit --}}
                                <a href="{{ route('barang-masuk.edit', $row->id) }}"
                                   class="inline-flex items-center justify-center p-2 bg-yellow-400/80 hover:bg-yellow-500 text-white rounded-md transition"
                                   title="Edit Transaksi">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>

                                {{-- Hapus --}}
                                <form action="{{ route('barang-masuk.destroy', $row->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')"
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center p-2 bg-red-500/80 hover:bg-red-600 text-white rounded-md transition"
                                            title="Hapus">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-4 text-center text-gray-500 italic">
                                Belum ada transaksi barang masuk.
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
                Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }}
                dari {{ $data->total() }} data
            </p>
            <div>
                {{ $data->appends(['search' => request('search')])->links('pagination::tailwind') }}
            </div>
        </div>
        @endif
    </div>
</div>

<script> lucide.createIcons(); </script>
@endsection
