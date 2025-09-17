<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    /**
     * Kolom yang bisa diisi secara mass-assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'username',
        'password',
        'id_unit_asal',
    ];

    /**
     * Kolom yang disembunyikan saat serialisasi (misalnya ke JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Relasi ke tabel unit_asal (Many-to-One).
     */
    public function unitAsal()
    {
        return $this->belongsTo(UnitAsal::class, 'id_unit_asal');
    }

    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'id_user', 'id');
    }
}
