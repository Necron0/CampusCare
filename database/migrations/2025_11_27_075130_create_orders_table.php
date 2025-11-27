<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penerima');
            $table->string('no_hp');
            $table->text('alamat');
            $table->string('opsi_pengiriman');
            $table->integer('ongkir')->default(0);
            $table->integer('total_harga')->default(0);
            $table->string('status')->default('diproses');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};




