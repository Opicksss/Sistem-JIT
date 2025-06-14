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
            $table->string('id_transaksi');
            $table->string('penerima');
            $table->foreignId('bahan_baku_id')->constrained('bahan_bakus')->onDelete('cascade');
            $table->foreignId('suplier_id')->constrained('supliers')->onDelete('cascade');
            $table->decimal('stok', 10, 3)->default(0);
            $table->date('tanggal_keluar');
            $table->decimal('stok_awal', 10, 3)->default(0);
            $table->decimal('sisa', 10, 3)->default(0); 
            $table->bigInteger('biaya_penyimpanan')->default(0);
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
