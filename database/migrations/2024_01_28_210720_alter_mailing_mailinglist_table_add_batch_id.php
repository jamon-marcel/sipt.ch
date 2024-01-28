<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMailingMailinglistTableAddBatchId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('mailing_mailinglist', function (Blueprint $table) {
        $table->integer('batch_id')->after('id');
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      // drop the column
      Schema::table('mailing_mailinglist', function (Blueprint $table) {
        $table->dropColumn('batch_id');
      });
    }
}
