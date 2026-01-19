<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Merk;
use App\Models\Satuan;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        // Ambil kata kunci pencarian (jika ada)
        $search = $request->search;

        // Query barang + relasi + filter pencarian + pagination
        $barang = Barang::with(['kategori', 'merk', 'satuan'])
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                             ->orWhere('kode', 'like', "%{$search}%");
            })
            ->orderBy('id', 'asc')
            ->paginate(10); // tampilkan 10 data per halaman

        // Kirim hasil ke view
        return view('master.barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = Kategori::orderBy('nama')->get();
        $merk = Merk::orderBy('nama')->get();
        $satuan = Satuan::orderBy('nama')->get();

        return view('master.barang.create', compact('kategori', 'merk', 'satuan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:barang',
            'nama' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategori,id',
            'merk_id' => 'required|exists:merk,id',
            'satuan_id' => 'required|exists:satuan,id',
            'stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        Barang::create($request->all());

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = Kategori::orderBy('nama')->get();
        $merk = Merk::orderBy('nama')->get();
        $satuan = Satuan::orderBy('nama')->get();

        return view('master.barang.edit', compact('barang', 'kategori', 'merk', 'satuan'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'kode' => 'required|unique:barang,kode,' . $barang->id,
            'nama' => 'required|string|max:100',
            'kategori_id' => 'required|exists:kategori,id',
            'merk_id' => 'required|exists:merk,id',
            'satuan_id' => 'required|exists:satuan,id',
            'stock' => 'nullable|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
        ]);

        $barang->update($request->all());

        return redirect()->route('barang.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Barang::findOrFail($id)->delete();
        return redirect()->route('barang.index')->with('success', 'Data barang berhasil dihapus!');
    }
}
