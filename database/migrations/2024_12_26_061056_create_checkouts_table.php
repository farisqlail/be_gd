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
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_price');
            $table->bigInteger("id_customer")->nullable();
            $table->bigInteger("id_promo")->nullable();
            $table->string("customer_name");
            $table->string("email_customer");
            $table->string("phone_customer");
            $table->string("transaction_code");
            $table->bigInteger("amount");
            $table->string("payment_status");
            $table->string("payment_method");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkouts');
    }
};
