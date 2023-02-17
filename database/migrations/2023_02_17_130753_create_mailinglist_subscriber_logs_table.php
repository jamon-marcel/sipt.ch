<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailinglistSubscriberLogsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('mailinglist_subscriber_logs', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->string('email');
      $table->string('action')->nullable();
      $table->tinyInteger('is_user')->default(0);
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
    Schema::dropIfExists('mailinglist_subscriber_logs');
  }
}
