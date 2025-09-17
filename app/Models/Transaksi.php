<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    // Nama tabel jika tidak mengikuti konvensi plural
    protected $table = 'transaksi';

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'idtransaksi',
        'tanggal',
        'idpasien',
        'norm',
        'nama',
        'tgl_lhr',
        'pasien_usia',
        'beratbadan',
        'tinggibadan',
        'alamat',
        'jeniskelamin',
        'kota',
        'jenispasien',
        'iddokterperujuk',
        'dokterperujuk',
        'iddokterpa',
        'dokterpa',
        'pelayananasal',
        'idunitasal',
        'unitasal',
        'register',
        'pemeriksaan',
        'responsetime',
        'statuslokasi',
        'diagnosaklinik',
        'hasil',
        'diagnosapatologi',
        'mutusediaan',
    ];

    // Field yang ingin disembunyikan jika serialisasi ke JSON
    protected $hidden = [];

    // Casting tipe data jika perlu
    protected $casts = [
        'tanggal' => 'datetime',
        'tgl_lhr' => 'date',
    ];
}
