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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user');
            $table->integer('id_produk');
            $table->integer('id_sumber');
            $table->integer('id_payment');
            $table->string('nama_customer',100);
            $table->string('kode_transaksi',100);
            $table->date('tanggal_pembelian');
            $table->date('tanggal_berakhir');
            $table->integer('harga');
            $table->string('wa',100);
            $table->string('tujuan_transaksi',100);
            $table->integer('status');
            $table->text('link_wa');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
