<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('cart_id')->references('id')->on('carts');
            $table->unsignedBigInteger('cart_id')->nullable();
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->foreign('delivery_id')->references('id')->on('deliveries');
            $table->unsignedBigInteger('delivery_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('
            ')->nullable();
            $table->string('total_price')->nullable();
            $table->string('discount_price')->nullable();
            $table->string('status')->nullable();
            $table->string('order_no')->nullable();
            $table->string('delivery_fee')->nullable();
            $table->boolean('is_active')->default(0)->nullable();
            $table->boolean('is_preorder')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
