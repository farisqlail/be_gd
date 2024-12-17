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
        Schema::create('detail_netflixes', function (Blueprint $table) {
            $table->id();
            $table->integer('id_produk');
            $table->integer('id_email');
            $table->string('profile');
            $table->string('pin');
            $table->integer('jumlah_pengguna');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_netflixes');
    }
};
