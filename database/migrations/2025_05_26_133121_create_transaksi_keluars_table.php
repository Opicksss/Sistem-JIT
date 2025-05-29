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
        Schema::create('transaksi_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('penerima');
            $table->foreignId('bahan_baku_id')
                ->constrained('bahan_bakus')
                ->onDelete('cascade');
             $table->foreignId('suplier_id')
                ->constrained('supliers')
                ->onDelete('cascade');
            $table->integer('stok');
            $table->date('tanggal_keluar');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_keluars');
    }
};
