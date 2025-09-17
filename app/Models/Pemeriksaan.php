<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan';

    /**
     * Kolom yang bisa diisi secara mass-assignment.
     */
    protected $fillable = [
        'id_transaksi',
        'id_pasien',
        'id_user',
        'tanggal_pemeriksaan',
        'status_lokasi',
        'diagnosa_klinik',
        'dokter_pengirim',
        'pesan_unit_asal',
        'nama_user_pa',
        'pesan_pa',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id');
    }
}
