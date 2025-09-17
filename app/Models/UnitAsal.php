<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAsal extends Model
{
    use HasFactory;

    protected $table = 'unit_asal';

    protected $fillable = ['nama'];

    // Relasi: 1 UnitAsal → Banyak User
    public function users()
    {
        return $this->hasMany(User::class, 'id_unit_asal');
    }
}
