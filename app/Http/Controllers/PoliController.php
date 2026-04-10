<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::latest()->get();
        return view('admin.polis.index', compact('polis'));
    }

    public function create()
    {
        return view('admin.polis.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_poli' => 'required|string|max:25',
            'keterangan' => 'nullable|string',
        ]);

        Poli::create($validated);

        return redirect()->route('polis.index')->with('success', 'Data poli berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $poli = Poli::findOrFail($id);
        return view('admin.polis.edit', compact('poli'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_poli' => 'required|string|max:25',
            'keterangan' => 'nullable|string',
        ]);

        $poli = Poli::findOrFail($id);
        $poli->update($validated);

        return redirect()->route('polis.index')->with('success', 'Data poli berhasil diupdate.');
    }

    public function destroy($id)
    {
        $poli = Poli::findOrFail($id);
        $poli->delete();

        return redirect()->route('polis.index')->with('success', 'Data poli berhasil dihapus.');
    }
}