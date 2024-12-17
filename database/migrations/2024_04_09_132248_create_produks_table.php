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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->integer('id_varian');
            $table->integer('id_jenis');
            $table->integer('durasi');
            $table->string('ket_durasi',150);
            $table->integer('batas_pengguna');
            $table->longText("deskripsi");
            $table->integer('deleted')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
