<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apotek_id')->constrained()->onDelete('cascade');
            $table->foreignId('obat_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('nama_promo');
            $table->text('deskripsi')->nullable();
            $table->enum('tipe_diskon', ['persentase', 'nominal']);
            $table->decimal('nilai_diskon', 10, 2);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('promos');
    }
};
