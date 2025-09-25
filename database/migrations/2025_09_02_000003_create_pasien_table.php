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
$table->bigInteger('idpasien')->nullable()->index(); // ID pasien eksternal jika ada
$table->string('norm', 50)->unique(); // Nomor rekam medis unik
$table->string('nik', 20)->nullable()->index(); // NIK dengan index untuk pencarian
$table->string('nama', 150); // Nama pasien dengan panjang terbatas
$table->text('alamat')->nullable(); // Alamat pasien, boleh kosong
$table->string('kota', 50)->nullable(); // Kota, opsional
$table->string('jenispasien', 50)->nullable(); // Jenis pasien, misalnya: rawat jalan, rawat inap
$table->enum('jenkel', ['L', 'P'])->nullable(); // Jenis kelamin, default laki-laki
$table->date('tgl_lhr')->nullable(); // Tanggal lahir, boleh kosong
$table->timestamps(); // created_at & updated_at
$table->softDeletes(); // Menambahkan SoftDeletes jika diperlukan
});
}

public function down(): void
{
Schema::dropIfExists('pasien');
}
};