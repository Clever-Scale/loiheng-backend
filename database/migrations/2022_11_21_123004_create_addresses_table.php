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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('city')->nullable();
            $table->string('township')->nullable();
            $table->string('region')->nullable();
            $table->string('phone')->nullable();
            $table->string('full_name');
            $table->boolean('is_default')->default(0)->nullable();
            $table->string('address_type')->nullable();
            $table->boolean('is_active')->default(1)->nullable();
            $table->string('street_address')->nullable();
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
        Schema::dropIfExists('addresses');
    }
};
