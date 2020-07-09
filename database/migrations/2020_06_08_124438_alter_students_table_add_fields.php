<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterStudentsTableAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->string('title', 200)->after('name')->nullable();
            $table->string('street', 100)->after('title');
            $table->string('street_no', 10)->after('street')->nullable();
            $table->string('city', 100)->after('street_no');
            $table->string('phone_business', 200)->after('phone')->nullable();
            $table->string('mobile', 200)->after('phone_business')->nullable();
            $table->string('qualifications', 200)->after('mobile');
            $table->string('alt_company', 200)->after('qualifications')->nullable();
            $table->string('alt_name', 100)->after('alt_company')->nullable();
            $table->string('alt_street', 100)->after('alt_name')->nullable();
            $table->string('alt_street_no', 10)->after('alt_street')->nullable();
            $table->string('alt_city', 100)->after('alt_street_no')->nullable();
            $table->tinyInteger('needs_credit_confirmation')->after('alt_city')->default(0);
            $table->tinyInteger('needs_hours_confirmation')->after('needs_credit_confirmation')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
