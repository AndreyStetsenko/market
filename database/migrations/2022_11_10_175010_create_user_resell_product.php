<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserResellProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_resell_product', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('creator_id')->unsigned();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('count');
            $table->integer('price');
            $table->string('currency');
            $table->timestamps();

            $table->foreign('creator_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_resell_product');
    }
}
