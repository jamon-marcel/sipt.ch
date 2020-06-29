<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablesAddSoftDeletes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('tutors', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('administrators', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('trainings', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('students', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('course_training', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('course_event_student', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('course_event_files', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('course_event_dates', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('course_events', function (Blueprint $table) {
            $table->softDeletes();
        });

        Schema::table('courses', function (Blueprint $table) {
            $table->softDeletes();
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
