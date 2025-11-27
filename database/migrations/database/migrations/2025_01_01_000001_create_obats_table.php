<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('kategori')->nullable();     // flu, demam, lambung, dll
            $table->string('gejala')->nullable();       // batuk, pilek, pusing
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(0);
            $table->integer('harga')->default(0);
            $table->string('lokasi_apotek')->nullable(); // contoh: Apotek A / Kampus
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};

