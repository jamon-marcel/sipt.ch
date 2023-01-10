<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMailinglistSubscriberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('mailinglist_subscriber', function (Blueprint $table) {
        $table->uuid('id')->primary();
        $table->uuid('mailinglist_id');
        $table->string('email');
        $table->string('description', 255);
        $table->text('error')->nullable();
        $table->tinyInteger('is_processed')->default(0);
        $table->tinyInteger('is_confirmed')->default(0);
        $table->foreign('mailinglist_id')->references('id')->on('mailinglists');
        $table->unique(['mailinglist_id', 'email']);
        $table->softDeletes();
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
      Schema::dropIfExists('mailinglist_subscriber');
    }
}
