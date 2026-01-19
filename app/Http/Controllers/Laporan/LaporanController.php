<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    // 🔹 Laporan Barang Masuk
    public function barangMasuk(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $search = $request->input('search');

        $query = BarangMasuk::with(['barang', 'user'])->orderBy('tanggal', 'desc');

        if ($from && $to) {
            $query->whereBetween('tanggal', [$from, $to]);
        }

        if ($search) {
            $query->whereHas('barang', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhere('keterangan', 'like', "%{$search}%");
        }

        $data = $query->paginate(10);

        return view('laporan.barang_masuk.index', compact('data', 'from', 'to', 'search'));
    }

    // 🔹 Laporan Barang Keluar
    public function barangKeluar(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');
        $search = $request->input('search');

        $query = BarangKeluar::with(['barang', 'customer', 'user'])->orderBy('tanggal', 'desc');

        if ($from && $to) {
            $query->whereBetween('tanggal', [$from, $to]);
        }

        if ($search) {
            $query->whereHas('barang', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })
            ->orWhereHas('customer', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            })
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhere('keterangan', 'like', "%{$search}%");
        }

        $data = $query->paginate(10);

        return view('laporan.barang_keluar.index', compact('data', 'from', 'to', 'search'));
    }

    // 🔹 PDF Barang Masuk
    public function barangMasukPDF(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = BarangMasuk::with(['barang', 'user'])->orderBy('tanggal', 'desc');
        if ($from && $to) $query->whereBetween('tanggal', [$from, $to]);
        $data = $query->get();

        $pdf = Pdf::loadView('laporan.barang_masuk.pdf', compact('data', 'from', 'to'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Barang_Masuk.pdf');
    }

    // 🔹 PDF Barang Keluar
    public function barangKeluarPDF(Request $request)
    {
        $from = $request->input('from');
        $to = $request->input('to');

        $query = BarangKeluar::with(['barang', 'customer', 'user'])->orderBy('tanggal', 'desc');
        if ($from && $to) $query->whereBetween('tanggal', [$from, $to]);
        $data = $query->get();

        $pdf = Pdf::loadView('laporan.barang_keluar.pdf', compact('data', 'from', 'to'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Laporan_Barang_Keluar.pdf');
    }
}
