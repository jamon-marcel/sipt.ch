<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMailinglistSubscriberTableAddHash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('mailinglist_subscriber', function (Blueprint $table) {
        $table->string('hash')->nullable()->after('email');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::table('mailinglist_subscriber', function (Blueprint $table) {
        $table->dropColumn('hash');
      });
    }
}
