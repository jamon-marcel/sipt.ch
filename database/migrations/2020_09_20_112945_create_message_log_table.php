<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_log', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email', 255);
            $table->tinyInteger('is_sent')->default(0);
            $table->uuid('message_id');
            $table->foreign('message_id')->references('id')->on('messages');
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
        Schema::dropIfExists('message_log');
    }
}
