<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAnniversaryRegistrationsRemoveNumberAndUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anniversary_registrations', function (Blueprint $table) {
            $table->dropColumn('number');
            $table->dropColumn('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anniversary_registrations', function (Blueprint $table) {
            $table->integer('number')->nullable();
            $table->uuid('user_id')->nullable();
        });
    }
}
