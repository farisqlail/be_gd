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
        Schema::create('akun_netflixes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produk');
            $table->string('email_netflix');
            $table->string('password');
            $table->string('tujuan_akun',100);
            // $table->string('password',100);
            $table->date('tanggal_pembuatan');
            $table->date('tanggal_scan');
            $table->integer('jumlah_pengguna');
            $table->string('nomor_akun');
            $table->string('status_akun')->default('Unscanned');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akun_netflixes');
    }
};
