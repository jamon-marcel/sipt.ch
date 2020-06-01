<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseEventDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_event_dates', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->date('date');
            $table->time('timeStart');
            $table->time('timeEnd');
            $table->uuid('course_event_id');
            $table->foreign('course_event_id')->references('id')->on('course_events');
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
        Schema::dropIfExists('course_event_dates');
    }
}
