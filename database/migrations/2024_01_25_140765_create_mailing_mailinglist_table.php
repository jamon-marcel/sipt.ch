<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingMailinglistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('mailinglist_mailing_queue', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('mailinglist_id');
        $table->foreign('mailinglist_id')->references('id')->on('mailinglists');
        $table->uuid('mailing_queue_id');
        $table->foreign('mailing_queue_id')->references('id')->on('mailing_queue');
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
      Schema::dropIfExists('mailing_mailinglist');
    }
}
