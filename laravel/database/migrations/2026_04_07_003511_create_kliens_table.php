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
        Schema::create('tb_klien', function (Blueprint $table) {
            $table->id('id_klien');
            $table->string('nama_klien', 100);
            $table->string('email_klien', 100)->unique();
            $table->string('telepon', 20)->nullable(); // nullable = boleh kosong
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kliens');
    }
};
