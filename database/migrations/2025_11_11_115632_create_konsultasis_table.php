<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mitra_id')->nullable()->constrained()->onDelete('cascade');

            // Data konsultasi dari form
            $table->string('kategori');
            $table->string('topik');
            $table->text('keluhan');
            $table->text('gejala_tambahan')->nullable();
            $table->string('riwayat_alergi')->nullable();
            $table->enum('urgensi', ['rendah', 'sedang', 'tinggi'])->default('sedang');
            $table->text('catatan')->nullable();

            // Data jawaban dari dokter/apoteker
            $table->text('jawaban')->nullable();
            $table->string('dokter')->nullable();
            $table->text('rekomendasi_obat')->nullable();
            $table->timestamp('dijawab_pada')->nullable();

            // Status konsultasi
            $table->enum('status', ['menunggu', 'diproses', 'selesai', 'dibatalkan'])->default('menunggu');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsultasis');
    }
};
