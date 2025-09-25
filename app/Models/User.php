<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes;  // Menambahkan SoftDeletes jika diperlukan

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

    /**
     * Relasi ke pemeriksaan (One-to-Many).
     */
    public function pemeriksaan()
    {
        return $this->hasMany(Pemeriksaan::class, 'id_user', 'id');
    }

    /**
     * Meng-hash password sebelum menyimpannya.
     *
     * @param string $password
     * @return string
     */
    public static function hashPassword(string $password)
    {
        return Hash::make($password);
    }

    /**
     * Cek apakah username sudah ada.
     *
     * @param string $username
     * @return bool
     */
    public static function usernameExists(string $username)
    {
        return self::where('username', $username)->exists();
    }
}