<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingQueueTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('mailing_queue', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->tinyInteger('processed')->default(0);
      $table->uuid('mailing_id');
      $table->foreign('mailing_id')->references('id')->on('mailings');
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
    Schema::dropIfExists('mailing_queue');
  }
}
