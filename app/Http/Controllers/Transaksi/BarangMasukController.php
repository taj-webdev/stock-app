<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\Barang;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $data = BarangMasuk::with(['barang', 'user'])
            ->when($search, function ($query, $search) {
                $query->whereHas('barang', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhere('tanggal', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('transaksi.barang_masuk.index', compact('data', 'search'));
    }

    public function create()
    {
        $barang = Barang::orderBy('nama')->get();
        return view('transaksi.barang_masuk.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required|exists:barang,id',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        BarangMasuk::create([
            'tanggal' => $request->tanggal,
            'barang_id' => $request->barang_id,
            'qty' => $request->qty,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('barang-masuk.index')->with('success', 'Transaksi Barang Masuk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = BarangMasuk::findOrFail($id);
        $barang = Barang::orderBy('nama')->get();

        return view('transaksi.barang_masuk.edit', compact('data', 'barang'));
    }

    public function update(Request $request, $id)
    {
        $data = BarangMasuk::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required|exists:barang,id',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $data->update([
            'tanggal' => $request->tanggal,
            'barang_id' => $request->barang_id,
            'qty' => $request->qty,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('barang-masuk.index')->with('success', 'Transaksi Barang Masuk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        BarangMasuk::findOrFail($id)->delete();
        return redirect()->route('barang-masuk.index')->with('success', 'Transaksi Barang Masuk berhasil dihapus!');
    }
}
