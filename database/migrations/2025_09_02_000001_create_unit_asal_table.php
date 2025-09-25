<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('unit_asal', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->index(); // Nama unit asal yang di-index
            $table->timestamps();
            $table->softDeletes(); // Menambahkan SoftDeletes
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('unit_asal');
    }
};
