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
        Schema::create('tb_invoice_detail', function (Blueprint $table) {
            $table->id('id_detail');
            $table->unsignedBigInteger('id_invoice');
            $table->unsignedBigInteger('id_produk');
            $table->integer('quantity')->default(1);
            $table->decimal('harga_jual_saat_ini', 15, 2);
            
            // Menggunakan GENERATED ALWAYS persis seperti rancangan SQL-mu
            $table->decimal('subtotal', 15, 2)->storedAs('quantity * harga_jual_saat_ini');
            $table->timestamps();

            // Relasi
            $table->foreign('id_invoice')->references('id_invoice')->on('tb_invoice')->onDelete('cascade');
            $table->foreign('id_produk')->references('id_produk')->on('tb_produk')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
