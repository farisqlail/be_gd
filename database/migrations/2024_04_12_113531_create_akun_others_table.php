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
        Schema::create('akun_others', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produk');
            $table->string('email_akun');
            $table->string('nomor_akun');
            $table->string('tujuan_akun');
            $table->date('tanggal_pembuatan');
            $table->integer('jumlah_pengguna');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_others');
    }
};
