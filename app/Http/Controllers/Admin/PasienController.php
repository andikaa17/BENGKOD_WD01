<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = User::where('role', 'pasien')
            ->latest()
            ->get();

        return view('admin.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('admin.pasien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'no_ktp'   => 'nullable|string|max:30|unique:users,no_ktp',
            'alamat'   => 'nullable|string',
            'no_hp'    => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
        ], [
            'nama.required'     => 'Nama pasien wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah digunakan.',
            'no_ktp.unique'     => 'No. KTP sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        // 🔥 GENERATE NO RM OTOMATIS
        $lastPasien = User::where('role', 'pasien')
            ->orderBy('id', 'desc')
            ->first();

        if ($lastPasien && $lastPasien->no_rm) {
            $lastNumber = (int) substr($lastPasien->no_rm, 2);
            $newNumber  = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $noRM = 'RM' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'no_ktp'   => $request->no_ktp, // 🔥 FIX
            'alamat'   => $request->alamat,
            'no_hp'    => $request->no_hp,
            'role'     => 'pasien',
            'no_rm'    => $noRM,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $pasien = User::where('role', 'pasien')
            ->findOrFail($id);

        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(Request $request, string $id)
    {
        $pasien = User::where('role', 'pasien')
            ->findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $pasien->id,
            'no_ktp'   => 'nullable|string|max:30|unique:users,no_ktp,' . $pasien->id,
            'alamat'   => 'nullable|string',
            'no_hp'    => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'nama'   => $request->nama,
            'email'  => $request->email,
            'no_ktp' => $request->no_ktp, // 🔥 FIX
            'alamat' => $request->alamat,
            'no_hp'  => $request->no_hp,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pasien->update($data);

        return redirect()
            ->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pasien = User::where('role', 'pasien')
            ->findOrFail($id);

        $pasien->delete();

        return redirect()
            ->route('admin.pasien.index')
            ->with('success', 'Data pasien berhasil dihapus.');
    }
}