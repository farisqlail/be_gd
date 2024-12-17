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
        Schema::create('platforms', function (Blueprint $table) {
            $table->id();
            $table->string('nama_platform',60);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
        });
        
        Schema::create('sumber_transaksis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_platform');
            $table->string('nama_sumber',150);
            $table->boolean('deleted')->default(false);
            $table->timestamps();
            $table->foreign('id_platform')->references('id')->on('platforms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sumber_transaksis');
    }
};
