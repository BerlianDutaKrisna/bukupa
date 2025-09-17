<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasien', function (Blueprint $table) {
            $table->id(); // id primary auto increment
            $table->bigInteger('idpasien')->nullable();
            $table->string('norm', 50)->unique();
            $table->string('nik', 20)->nullable();
            $table->string('nama', 255);
            $table->text('alamat')->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('jenispasien', 50)->nullable();
            $table->enum('jenkel', ['L', 'P'])->default('L');
            $table->date('tgl_lhr')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
