<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto_increment
            $table->string('nama', 150); // Nama dengan panjang terbatas
            $table->string('username', 255)->unique(); // Username unik
            $table->text('password'); // Penyimpanan password dengan tipe text
            $table->foreignId('id_unit_asal')->constrained('unit_asal')->onDelete('cascade'); // Relasi dengan unit_asal
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // Menambahkan SoftDeletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
