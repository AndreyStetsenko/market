<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttachmentableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachmentable', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attachment_id')->unsigned();;
            $table->bigInteger('attachmentable_id')->unsigned();;
            $table->timestamps();

            $table->foreign('attachment_id')
                ->references('id')
                ->on('attachments')
                ->cascadeOnDelete();

            $table->foreign('attachmentable_id')
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
        Schema::dropIfExists('attachmentable');
    }
}
