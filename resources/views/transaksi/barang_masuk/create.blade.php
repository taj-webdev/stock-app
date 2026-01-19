@extends('layouts.app')

@section('content')
<div class="animate-fadeIn space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i data-lucide="package-plus" class="w-6 h-6 text-blue-500"></i>
            Tambah Barang Masuk
        </h2>
        <a href="{{ route('barang-masuk.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('barang-masuk.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Tanggal --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" value="{{ date('Y-m-d') }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                       required>
            </div>

            {{-- Barang --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Pilih Barang <span class="text-red-500">*</span></label>
                <select name="barang_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                        required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->id }}">{{ $b->kode }} - {{ $b->nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah Masuk --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Jumlah Masuk <span class="text-red-500">*</span></label>
                <input type="number" name="qty" min="1"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                       placeholder="Masukkan jumlah barang masuk" required>
            </div>

            {{-- Keterangan --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Keterangan</label>
                <input type="text" name="keterangan"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                       placeholder="Opsional, misal: pengiriman supplier ABC">
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all">
                    <i data-lucide="save" class="w-5 h-5"></i> Simpan
                </button>
                <a href="{{ route('barang-masuk.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
                    <i data-lucide="x-circle" class="w-5 h-5"></i> Batal
                </a>
            </div>
        </form>
    </div>

</div>

<script> lucide.createIcons(); </script>
@endsection
