<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $kategori = Kategori::when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->paginate(10);

        return view('master.kategori.index', compact('kategori', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|unique:kategori']);
        Kategori::create($request->only('nama'));
        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);
        $request->validate(['nama' => 'required|unique:kategori,nama,' . $kategori->id]);
        $kategori->update($request->only('nama'));
        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();
        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
