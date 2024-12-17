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
        Schema::create('variances', function (Blueprint $table) {
            $table->id();
            $table->string('variance_name',150);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('type_name',150);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_varian');
            $table->unsignedBigInteger('id_jenis');
            $table->string('kode_produk',80);
            $table->integer('durasi');
            $table->string('ket_durasi',40);
            $table->integer('batas_pengguna');
            $table->boolean('deleted')->default(false);
            $table->timestamps();
            $table->foreign('id_varian')->references('id')->on('variances');
            $table->foreign('id_jenis')->references('id')->on('product_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
