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
        Schema::create('tb_invoice', function (Blueprint $table) {
            $table->id('id_invoice');
            $table->string('no_invoice', 30)->unique();
            $table->unsignedBigInteger('id_klien');
            $table->unsignedBigInteger('id_admin');
            $table->date('tanggal_buat');
            $table->date('tanggal_jatuh_tempo');
            $table->decimal('total', 15, 2)->default(0);
            $table->enum('status', ['Draft', 'Sent', 'Paid', 'Overdue'])->default('Draft');
            $table->timestamps();

            // Relasi (Foreign Keys)
            $table->foreign('id_klien')->references('id_klien')->on('tb_klien')->onDelete('restrict');
            $table->foreign('id_admin')->references('id_admin')->on('tb_admin')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
