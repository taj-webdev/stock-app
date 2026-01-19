<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Satuan;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $satuan = Satuan::when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->paginate(10);

        return view('master.satuan.index', compact('satuan', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|unique:satuan']);
        Satuan::create($request->only('nama'));
        return back()->with('success', 'Satuan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $satuan = Satuan::findOrFail($id);
        $request->validate(['nama' => 'required|unique:satuan,nama,' . $satuan->id]);
        $satuan->update($request->only('nama'));
        return back()->with('success', 'Satuan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Satuan::findOrFail($id)->delete();
        return back()->with('success', 'Satuan berhasil dihapus!');
    }
}
