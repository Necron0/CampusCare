<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('obats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');
            $table->string('nama_obat');
            $table->string('kategori')->nullable();
            $table->string('gejala')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(0);
            $table->integer('harga')->default(0);
            $table->string('lokasi_apotek')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('obats');
    }
};
