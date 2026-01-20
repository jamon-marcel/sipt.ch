<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAnniversaryRegistrationsRemoveBilledAndPaid extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anniversary_registrations', function (Blueprint $table) {
            $table->dropColumn('is_billed');
            $table->dropColumn('is_paid');
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
            $table->tinyInteger('is_billed')->default(0);
            $table->tinyInteger('is_paid')->default(0);
        });
    }
}
