@extends('layouts.app')

@section('content')
<div class="animate-fadeIn space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i data-lucide="package-open" class="w-6 h-6 text-yellow-500"></i>
            Edit Barang Masuk
        </h2>
        <a href="{{ route('barang-masuk.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('barang-masuk.update', $data->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Tanggal --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="tanggal" value="{{ $data->tanggal }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 px-4 py-2"
                       required>
            </div>

            {{-- Barang --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Pilih Barang <span class="text-red-500">*</span></label>
                <select name="barang_id"
                        class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 px-4 py-2"
                        required>
                    @foreach($barang as $b)
                        <option value="{{ $b->id }}" {{ $data->barang_id == $b->id ? 'selected' : '' }}>
                            {{ $b->kode }} - {{ $b->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jumlah --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Jumlah Masuk <span class="text-red-500">*</span></label>
                <input type="number" name="qty" value="{{ $data->qty }}" min="1"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 px-4 py-2"
                       required>
            </div>

            {{-- Keterangan --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Keterangan</label>
                <input type="text" name="keterangan" value="{{ $data->keterangan }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-yellow-500 focus:border-yellow-500 px-4 py-2"
                       placeholder="Opsional, misal: retur barang, koreksi stok">
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all">
                    <i data-lucide="save" class="w-5 h-5"></i> Update
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
