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
      $table->string('email');
      $table->string('hash');
      $table->text('error')->nullable();
      $table->tinyInteger('processed')->default(0);
      $table->uuid('mailing_id');
      $table->foreign('mailing_id')->references('id')->on('mailings');
      $table->uuid('mailinglist_id')->nullable();
      $table->foreign('mailinglist_id')->references('id')->on('mailinglists');
      $table->uuid('mailinglist_subscriber_id')->nullable();
      $table->foreign('mailinglist_subscriber_id')->references('id')->on('mailinglist_subscriber');
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
