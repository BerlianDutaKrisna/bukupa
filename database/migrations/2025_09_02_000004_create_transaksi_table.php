<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id(); // id primary key auto-increment
            $table->bigInteger('idtransaksi')->nullable()->index(); // ID transaksi dari API (bigint, nullable)
            $table->dateTime('tanggal')->nullable(); // Tanggal transaksi
            $table->foreignId('idpasien')->nullable()->constrained('pasien')->onDelete('set null'); // Relasi dengan pasien
            $table->string('norm')->nullable();
            $table->string('nama')->nullable();
            $table->date('tgl_lhr')->nullable();
            $table->string('pasien_usia')->nullable();
            $table->string('beratbadan')->nullable();
            $table->string('tinggibadan')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jeniskelamin', ['L', 'P'])->nullable(); // Jenis kelamin, enum L/P
            $table->string('kota')->nullable();
            $table->string('jenispasien')->nullable();
            $table->string('dokterperujuk')->nullable();  // Nama dokter perujuk
            $table->string('dokterpa')->nullable();  // Nama dokter PA
            $table->string('pelayananasal')->nullable();
            $table->foreignId('idunitasal')->nullable()->constrained('unit_asal')->onDelete('set null'); // Relasi dengan unit asal
            $table->string('unitasal')->nullable();
            $table->string('register')->nullable();
            $table->string('pemeriksaan')->nullable();
            $table->string('responsetime')->nullable();
            $table->string('statuslokasi', 100)->nullable(); // Status lokasi (varchar, panjang 100 karakter)
            $table->text('diagnosaklinik')->nullable(); // Diagnosis klinik, menggunakan text untuk panjang
            $table->text('hasil')->nullable(); // Hasil pemeriksaan
            $table->text('diagnosapatologi')->nullable(); // Diagnosis patologi
            $table->string('mutusediaan')->nullable();
            $table->timestamps(); // created_at & updated_at
            $table->softDeletes(); // Menambahkan SoftDeletes
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};