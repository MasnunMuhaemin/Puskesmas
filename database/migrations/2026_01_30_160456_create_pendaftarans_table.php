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
        Schema::create('pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')
                ->constrained('pasiens')
                ->cascadeOnDelete();
            $table->foreignId('poli_id')
                ->constrained('polis')
                ->cascadeOnDelete();
            $table->date('tanggal_daftar');
            $table->enum('status', ['menunggu', 'selesai', 'batal'])
                ->default('menunggu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendaftarans');
    }
};
