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
        Schema::create('detail_akuns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_akun');
            $table->string('profile',50)->nullable();
            $table->string('pin')->nullable();
            $table->integer('jumlah_pengguna')->default(0);
            $table->timestamps();

            $table->foreign('id_akun')->references('id')->on('akuns');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_akuns');
    }
};
