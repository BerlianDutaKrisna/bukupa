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
            $table->id(); // id primary key autoincrement
            $table->string('idtransaksi')->nullable();
            $table->dateTime('tanggal')->nullable();
            $table->bigInteger('idpasien')->nullable();
            $table->string('norm')->nullable();
            $table->string('nama')->nullable();
            $table->date('tgl_lhr')->nullable();
            $table->string('pasien_usia')->nullable();
            $table->string('beratbadan')->nullable();
            $table->string('tinggibadan')->nullable();
            $table->text('alamat')->nullable();
            $table->string('jeniskelamin')->nullable();
            $table->string('kota')->nullable();
            $table->string('jenispasien')->nullable();
            $table->bigInteger('iddokterperujuk')->nullable();
            $table->string('dokterperujuk')->nullable();
            $table->bigInteger('iddokterpa')->nullable();
            $table->string('dokterpa')->nullable();
            $table->string('pelayananasal')->nullable();
            $table->bigInteger('idunitasal')->nullable();
            $table->string('unitasal')->nullable();
            $table->string('register')->nullable();
            $table->string('pemeriksaan')->nullable();
            $table->string('responsetime')->nullable();
            $table->string('statuslokasi')->nullable();
            $table->string('diagnosaklinik')->nullable();
            $table->text('hasil')->nullable();
            $table->string('diagnosapatologi')->nullable();
            $table->string('mutusediaan')->nullable();
            $table->timestamps();
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
