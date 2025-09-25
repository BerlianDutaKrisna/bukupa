<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemeriksaan', function (Blueprint $table) {
            $table->id(); // primary key autoincrement
            $table->unsignedBigInteger('id_transaksi')->nullable();
            $table->unsignedBigInteger('id_pasien')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->dateTime('tanggal_pemeriksaan')->nullable();
            $table->string('status_lokasi')->nullable();
            $table->text('diagnosa_klinik')->nullable();
            $table->string('dokter_pengirim')->nullable();
            $table->text('pesan_unit_asal')->nullable();
            $table->string('foto_unit_asal', 255)->nullable(); // Path foto dengan panjang 255
            $table->string('nama_user_pa')->nullable();
            $table->text('pesan_pa')->nullable();
            $table->string('status', 50)->nullable()->index(); // Menggunakan varchar untuk status dengan index
            $table->timestamps();

            // Foreign keys
            $table->foreign('id_transaksi')->references('id')->on('transaksi')->onDelete('set null');
            $table->foreign('id_pasien')->references('id')->on('pasien')->onDelete('set null');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('set null');

            // Index untuk kolom foreign key
            $table->index(['id_transaksi', 'id_pasien', 'id_user']); // Index pada foreign keys
            $table->softDeletes(); // Menambahkan SoftDeletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan');
    }
};
