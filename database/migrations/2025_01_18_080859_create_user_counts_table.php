<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCountsTable extends Migration
{
    public function up()
    {
        Schema::create('user_counts', function (Blueprint $table) {
            $table->id();
            $table->integer('count')->default(0);
            $table->date('last_updated')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_counts');
    }
}
