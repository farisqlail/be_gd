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
        Schema::create('potongans', function (Blueprint $table) {
            $table->id();
            $table->integer('id_platform');
            $table->integer('potongan_fix')->nullable();
            $table->float('potongan_persen')->nullable();
            $table->integer('deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('potongans');
    }
};
