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
        Schema::create('tb_pembayaran', function (Blueprint $table) {
            $table->id('id_pembayaran');
            $table->unsignedBigInteger('id_invoice');
            $table->unsignedBigInteger('id_admin');
            $table->date('tanggal_bayar');
            $table->decimal('jumlah_bayar', 15, 2);
            $table->enum('metode_bayar', ['Transfer Bank', 'QRIS', 'Tunai']);
            $table->string('bukti_transfer', 255)->nullable();
            $table->enum('status_verifikasi', ['Pending', 'Verified', 'Rejected'])->default('Pending');
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Relasi
            $table->foreign('id_invoice')->references('id_invoice')->on('tb_invoice')->onDelete('cascade');
            $table->foreign('id_admin')->references('id_admin')->on('tb_admin')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
