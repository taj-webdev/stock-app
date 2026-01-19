<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $data = BarangKeluar::with(['barang', 'customer', 'user'])
            ->when($search, function ($query, $search) {
                $query->whereHas('barang', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('nama', 'like', "%{$search}%");
                    })
                    ->orWhere('tanggal', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return view('transaksi.barang_keluar.index', compact('data', 'search'));
    }

    public function create()
    {
        $barang = Barang::orderBy('nama')->get();
        $customers = Customer::orderBy('nama')->get();
        return view('transaksi.barang_keluar.create', compact('barang', 'customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required|exists:barang,id',
            'customer_id' => 'nullable|exists:customers,id',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        BarangKeluar::create([
            'tanggal' => $request->tanggal,
            'barang_id' => $request->barang_id,
            'customer_id' => $request->customer_id,
            'qty' => $request->qty,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('barang-keluar.index')->with('success', 'Transaksi Barang Keluar berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data = BarangKeluar::findOrFail($id);
        $barang = Barang::orderBy('nama')->get();
        $customers = Customer::orderBy('nama')->get();

        return view('transaksi.barang_keluar.edit', compact('data', 'barang', 'customers'));
    }

    public function update(Request $request, $id)
    {
        $data = BarangKeluar::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date',
            'barang_id' => 'required|exists:barang,id',
            'customer_id' => 'nullable|exists:customers,id',
            'qty' => 'required|integer|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $data->update([
            'tanggal' => $request->tanggal,
            'barang_id' => $request->barang_id,
            'customer_id' => $request->customer_id,
            'qty' => $request->qty,
            'keterangan' => $request->keterangan,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('barang-keluar.index')->with('success', 'Transaksi Barang Keluar berhasil diperbarui!');
    }

    public function destroy($id)
    {
        BarangKeluar::findOrFail($id)->delete();
        return redirect()->route('barang-keluar.index')->with('success', 'Transaksi Barang Keluar berhasil dihapus!');
    }
}
