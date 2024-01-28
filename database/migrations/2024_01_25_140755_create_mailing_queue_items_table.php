<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailingQueueItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('mailing_queue_items', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->text('error')->nullable();
        $table->tinyInteger('processed')->default(0);
        $table->uuid('mailinglist_subscriber_id')->nullable();
        $table->foreign('mailinglist_subscriber_id')->references('id')->on('mailinglist_subscriber');  
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
        Schema::dropIfExists('mailing_queue_items');
    }
}
