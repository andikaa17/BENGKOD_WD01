<?php

namespace App\Http\Controllers;

use App\Models\Poli;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Obat;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalPoli' => class_exists(Poli::class) ? Poli::count() : 0,
            'totalDokter' => class_exists(Dokter::class) ? Dokter::count() : 0,
            'totalPasien' => class_exists(Pasien::class) ? Pasien::count() : 0,
            'totalObat' => class_exists(Obat::class) ? Obat::count() : 0,
            'today' => Carbon::now()->translatedFormat('l, d F Y'),
        ]);
    }
}