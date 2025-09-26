<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pasien extends Model
{
    use HasFactory, SoftDeletes; // Menambahkan SoftDeletes jika diperlukan

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

    protected $casts = [
        'tgl_lhr' => 'date',
    ];

    /**
     * Relasi ke pemeriksaan (One-to-Many).
     */
    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'id_pasien', 'id');
    }

    /**
     * Scope untuk mendapatkan pasien berdasarkan norm.
     */
    public function scopeByNorm($query, $norm)
    {
        return $query->where('norm', $norm);
    }

    /**
     * Validasi jika NIK sudah ada.
     */
    public static function nikExists($nik)
    {
        return self::where('nik', $nik)->exists();
    }
}
