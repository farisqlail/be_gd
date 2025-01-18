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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->unsignedBigInteger('id_price');
            $table->unsignedBigInteger('id_customer')->nullable();
            $table->unsignedBigInteger('id_payment')->nullable();
            $table->string('nama_customer',100)->nullable();
            $table->string('kode_transaksi',80)->nullable();
            $table->date('tanggal_pembelian');
            $table->date('tanggal_berakhir');
            $table->integer('harga');
            $table->string('wa');
            $table->string('status');
            $table->text('link_wa')->nullable();
            $table->enum('status_pembayaran',['Lunas','Kredit']);
            $table->boolean('promo')->default(false);
            $table->string('payment_method');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_price')->references('id')->on('prices');
        });

        Schema::create('detail_transactions',function (Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_detail_akun');
            $table->unsignedBigInteger('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id')->on('transactions');
            $table->foreign('id_detail_akun')->references('id')->on('detail_akuns');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
