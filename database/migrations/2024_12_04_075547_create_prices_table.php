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
        Schema::create('prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_toko');
            $table->unsignedBigInteger('id_produk');
            $table->string('kode_toko',100)->nullable();
            $table->integer('harga')->default(0);
            $table->boolean('deleted')->default(false);
            $table->timestamps();

            $table->foreign('id_toko')->references('id')->on('sumber_transaksis');
            $table->foreign('id_produk')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prices');
    }
};
