<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('mitra_id')->constrained()->onDelete('cascade');

            // Info pengiriman
            $table->string('nama_penerima');
            $table->string('no_hp');
            $table->text('alamat_pengiriman');
            $table->enum('opsi_pengiriman', ['pickup', 'delivery'])->default('delivery');

            // Biaya
            $table->integer('ongkir')->default(0);
            $table->integer('total_harga')->default(0);

            // Status
            $table->enum('status', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');

            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
