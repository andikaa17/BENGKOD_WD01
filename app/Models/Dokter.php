<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dokter extends Authenticatable
{
    protected $fillable = [
        'nama_dokter',
        'email',
        'no_ktp',
        'no_hp',
        'alamat',
        'poli_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class);
    }
}