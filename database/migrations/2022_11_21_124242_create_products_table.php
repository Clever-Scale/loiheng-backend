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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_code');
            $table->string('name');
            $table->string('price');
            $table->string('cover_img')->nullable();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->string('sku')->nullable();
            $table->string('desc_file')->nullable();
            $table->boolean('status')->nullable();
            $table->integer('approved_by')->nullable();
            $table->timestamp('approved_when')->nullable();
            $table->boolean('is_active')->default(1)->nullable();
            $table->boolean('is_preorder')->default(0)->nullable();
            $table->boolean('is_feature_product')->default(0)->nullable();
            $table->boolean('is_new_arrival')->default(0)->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->unsignedBigInteger('brand_id')->nullable();
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
        Schema::dropIfExists('products');
    }
};
