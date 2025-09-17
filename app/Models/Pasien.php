<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $fillable = [
        'idpasien',
        'norm',
        'nik',
        'nama',
        'alamat',
        'kota',
        'jenkel',
        'tgl_lhr',
    ];

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'id_pasien', 'id');
    }
}
