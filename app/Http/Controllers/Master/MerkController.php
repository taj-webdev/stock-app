<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merk;

class MerkController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $merk = Merk::when($search, function ($query, $search) {
                $query->where('nama', 'like', "%{$search}%");
            })
            ->orderBy('nama')
            ->paginate(10);

        return view('master.merk.index', compact('merk', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|unique:merk']);
        Merk::create($request->only('nama'));
        return back()->with('success', 'Merk berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $merk = Merk::findOrFail($id);
        $request->validate(['nama' => 'required|unique:merk,nama,' . $merk->id]);
        $merk->update($request->only('nama'));
        return back()->with('success', 'Merk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Merk::findOrFail($id)->delete();
        return back()->with('success', 'Merk berhasil dihapus!');
    }
}
