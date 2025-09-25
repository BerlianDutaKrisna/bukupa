<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitAsal extends Model
{
    use HasFactory, SoftDeletes;  // Menambahkan SoftDeletes jika diperlukan

    protected $table = 'unit_asal'; // Nama tabel yang sesuai

    protected $fillable = ['nama'];  // Kolom yang dapat diisi massal

    // Relasi: 1 UnitAsal → Banyak User
    public function users()
    {
        return $this->hasMany(User::class, 'id_unit_asal');
    }

    // Relasi: 1 UnitAsal → Banyak Transaksi (contoh)
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'idunitasal');
    }

    // Scope untuk mendapatkan unit asal yang aktif
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
