<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Poli extends Model
{
    use HasFactory;

    protected $table = 'poli';

    protected $fillable = [
        'nama_poli',
        'keterangan',
        'tarif',
        'kode_poli',
    ];

    public function dokters()
    {
        return $this->hasMany(User::class, 'id_poli')->where('role', 'dokter');
    }
    public function poli()
    {
        return $this->belongsTo(Poli::class, 'id_poli');
    }
}