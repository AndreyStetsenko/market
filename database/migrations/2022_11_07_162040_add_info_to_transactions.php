<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoToTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('checkout_url')->nullable();
            $table->string('status_url')->nullable();
            $table->string('qrcode_url')->nullable();
            $table->string('txn_id')->nullable();
            $table->string('address')->nullable();
            $table->string('confirms_needed')->nullable();
            $table->string('timeout')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
        });
    }
}
