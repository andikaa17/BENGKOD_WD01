<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = Pasien::latest()->get();
        return view('pasiens.index', compact('pasiens'));
    }

    public function create()
    {
        return view('pasiens.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ]);

        Pasien::create($validated);

        return redirect()->route('pasiens.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasiens.show', compact('pasien'));
    }

    public function edit(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        return view('pasiens.edit', compact('pasien'));
    }

    public function update(Request $request, string $id)
    {
        $pasien = Pasien::findOrFail($id);

        $validated = $request->validate([
            'nama_pasien' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $pasien->update($validated);

        return redirect()->route('pasiens.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();

        return redirect()->route('pasiens.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}