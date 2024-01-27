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
      Schema::create('mailing_mailinglist', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('mailing_id');
        $table->foreign('mailing_id')->references('id')->on('mailings');
        $table->uuid('mailinglist_id');
        $table->foreign('mailinglist_id')->references('id')->on('mailinglists');
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
