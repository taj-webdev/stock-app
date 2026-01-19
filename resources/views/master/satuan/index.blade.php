@extends('layouts.app')

@section('content')
<div class="animate-fadeIn space-y-6">

    {{-- Header + Search --}}
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i data-lucide="layers" class="w-6 h-6 text-blue-500"></i>
            Master Satuan
        </h2>

        <form action="{{ route('satuan.index') }}" method="GET"
              class="flex items-center bg-white rounded-lg shadow-sm border px-3 py-2 w-full sm:w-72">
            <i data-lucide="search" class="w-5 h-5 text-gray-400"></i>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari satuan..."
                   class="ml-2 w-full outline-none text-sm text-gray-700 bg-transparent">
        </form>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="p-3 rounded-md bg-green-100 text-green-800 text-sm border border-green-300 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Form Tambah --}}
    <div class="bg-white rounded-xl shadow-md p-5">
        <form action="{{ route('satuan.store') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-center">
            @csrf
            <div class="w-full md:w-1/2">
                <input type="text" name="nama" placeholder="Nama Satuan"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                       required>
            </div>
            <div>
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i> Tambah
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Data --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm text-left border-collapse">
                <thead class="bg-gray-100 border-b text-gray-700">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-center w-16">No</th>
                        <th class="px-4 py-3 font-semibold">Nama Satuan</th>
                        <th class="px-4 py-3 font-semibold text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($satuan as $index => $row)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-2 text-center text-gray-600">
                                {{ $satuan->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-2 text-gray-800 font-medium">{{ $row->nama }}</td>
                            <td class="px-4 py-2 text-center">
                                <form action="{{ route('satuan.destroy', $row->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus satuan ini?')"
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
                            <td colspan="3" class="px-4 py-4 text-center text-gray-500 italic">
                                Belum ada data satuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($satuan->hasPages())
        <div class="p-4 border-t flex flex-col sm:flex-row justify-between items-center gap-2">
            <p class="text-sm text-gray-500">
                Menampilkan {{ $satuan->firstItem() ?? 0 }} - {{ $satuan->lastItem() ?? 0 }} dari {{ $satuan->total() }} data
            </p>
            <div>
                {{ $satuan->appends(['search' => request('search')])->links('pagination::tailwind') }}
            </div>
        </div>
        @endif
    </div>

</div>

<script> lucide.createIcons(); </script>
@endsection
