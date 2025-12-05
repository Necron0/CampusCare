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
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id();

            // Untuk siapa notifikasi ini (mitra_id)
            $table->foreignId('mitra_id')->constrained('mitras')->onDelete('cascade');

            // Tipe notifikasi
            $table->enum('type', [
                'pesanan_baru',
                'pertanyaan_obat',
                'pesanan_dibatalkan',
                'review_baru',
                'stok_rendah',
                'promosi_berakhir'
            ]);

            // Judul & Pesan notifikasi
            $table->string('judul');
            $table->text('pesan');

            // Link ke halaman terkait (nullable)
            $table->string('link')->nullable();

            // Data tambahan (JSON untuk fleksibilitas)
            $table->json('data')->nullable();

            // Status sudah dibaca atau belum
            $table->boolean('dibaca')->default(false);
            $table->timestamp('dibaca_pada')->nullable();

            $table->timestamps();

            // Index untuk performa
            $table->index(['mitra_id', 'dibaca']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasis');
    }
};
