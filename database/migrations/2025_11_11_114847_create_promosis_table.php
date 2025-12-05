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
        Schema::create('promosis', function (Blueprint $table) {
            $table->id();

            // Foreign key ke obat
            $table->foreignId('obat_id')->constrained()->onDelete('cascade');

            // Kolom tambahan (opsional)
            $table->string('nama_promosi')->nullable();
            $table->text('deskripsi')->nullable();

            // Diskon (persen 1-100)
            $table->integer('diskon')->default(0);

            // Periode promosi
            $table->date('mulai');
            $table->date('berakhir');

            // Status aktif/nonaktif
            $table->boolean('aktif')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promosis');
    }
};
