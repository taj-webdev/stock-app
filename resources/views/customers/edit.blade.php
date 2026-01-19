@extends('layouts.app')

@section('content')
<div class="animate-fadeIn space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-semibold text-gray-800 flex items-center gap-2">
            <i data-lucide="user-cog" class="w-6 h-6 text-yellow-500"></i>
            Edit Customer
        </h2>
        <a href="{{ route('customers.index') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    {{-- Card Form --}}
    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('customers.update', $customer->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama Customer --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Customer <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $customer->nama) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2"
                       required>
            </div>

            {{-- Telepon --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">No. Telepon</label>
                <input type="text" name="telepon" value="{{ old('telepon', $customer->telepon) }}"
                       class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2">
            </div>

            {{-- Alamat --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Alamat</label>
                <textarea name="alamat" rows="3"
                          class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 px-4 py-2">{{ old('alamat', $customer->alamat) }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex items-center gap-3 pt-2">
                <button type="submit"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all">
                    <i data-lucide="save" class="w-5 h-5"></i> Update
                </button>
                <a href="{{ route('customers.index') }}"
                   class="inline-flex items-center gap-2 px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all">
                    <i data-lucide="x-circle" class="w-5 h-5"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script> lucide.createIcons(); </script>
@endsection
