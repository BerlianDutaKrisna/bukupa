<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaksi extends Model
{
    use HasFactory, SoftDeletes;  // Menambahkan SoftDeletes jika diperlukan

    protected $table = 'transaksi';  // Nama tabel jika tidak mengikuti konvensi plural

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
        'iddokterperujuk',  // ID Dokter Perujuk (bisa jadi optional)
        'dokterperujuk',     // Nama Dokter Perujuk
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

    protected $hidden = [
        // Kolom yang ingin disembunyikan saat serialisasi (misalnya ke JSON)
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'tgl_lhr' => 'date',
    ];

    /**
     * Relasi ke tabel Pasien (Many-to-One).
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'idpasien');
    }

    /**
     * Relasi ke unit asal (Many-to-One).
     */
    public function unitAsal()
    {
        return $this->belongsTo(UnitAsal::class, 'idunitasal');
    }

    /**
     * Menambahkan mutator untuk idtransaksi jika diperlukan
     */
    public function setIdtransaksiAttribute($value)
    {
        $this->attributes['idtransaksi'] = strtoupper($value);  // Menjadikan ID transaksi dalam huruf besar
    }

    /**
     * Contoh scope untuk transaksi yang belum dibayar
     */
    public function scopeUnpaid($query)
    {
        return $query->where('status', 'unpaid');
    }

    /**
     * Menambahkan metode untuk memeriksa apakah dokter perujuk valid
     */
    public function isDokterPerujukValid()
    {
        // Cek apakah dokter perujuk sudah terisi dengan benar
        return !empty($this->dokterperujuk);
    }
}