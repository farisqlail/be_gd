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
        Schema::create('akuns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_metode')->default(0);
            $table->string('email',200)->nullable();
            $table->string('tujuan_akun',100)->nullable();
            $table->string('password')->nullable();
            $table->date('tanggal_pembuatan')->nullable();
            $table->integer('jumlah_pengguna')->default(0);
            $table->string('nomor_akun')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();

            $table->foreign('id_produk')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('akuns');
    }
};
