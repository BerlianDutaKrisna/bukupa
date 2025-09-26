<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaksi';

    /**
     * Kolom yang bisa diisi mass-assignment
     */
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

    /**
     * Casting tipe data
     */
    protected $casts = [
        'tanggal' => 'datetime',
        'tgl_lhr' => 'date',
    ];
}
