<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use App\Models\Poli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::with('poli')->latest()->get();
        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        $polis = Poli::all();
        return view('admin.dokter.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:dokters,email',
            'no_ktp' => 'required|string|max:50|unique:dokters,no_ktp',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'poli_id' => 'required|exists:poli,id',
            'password' => 'required|min:6',
        ]);

        Dokter::create([
            'nama_dokter' => $validated['nama_dokter'],
            'email' => $validated['email'],
            'no_ktp' => $validated['no_ktp'],
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'poli_id' => $validated['poli_id'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dokter = Dokter::findOrFail($id);
        $polis = Poli::all();

        return view('admin.dokter.edit', compact('dokter', 'polis'));
    }

    public function update(Request $request, $id)
    {
        $dokter = Dokter::findOrFail($id);

        $validated = $request->validate([
            'nama_dokter' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:dokters,email,' . $dokter->id,
            'no_ktp' => 'required|string|max:50|unique:dokters,no_ktp,' . $dokter->id,
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'poli_id' => 'required|exists:poli,id',
            'password' => 'nullable|confirmed|min:6',
        ]);

        $dokter->nama_dokter = $validated['nama_dokter'];
        $dokter->email = $validated['email'];
        $dokter->no_ktp = $validated['no_ktp'];
        $dokter->no_hp = $validated['no_hp'];
        $dokter->alamat = $validated['alamat'];
        $dokter->poli_id = $validated['poli_id'];

        if (!empty($validated['password'])) {
            $dokter->password = Hash::make($validated['password']);
        }

        $dokter->save();

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->delete();

        return redirect()->route('dokter.index')->with('success', 'Data dokter berhasil dihapus.');
    }
}