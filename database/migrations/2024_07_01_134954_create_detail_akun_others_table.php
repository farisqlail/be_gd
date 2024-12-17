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
        Schema::create('detail_akun_others', function (Blueprint $table) {
            $table->id();
            $table->integer('id_akunOther');
            $table->string('profile',100);
            $table->string('pin',20);
            $table->integer('jumlah_pengguna')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_akun_others');
    }
};
