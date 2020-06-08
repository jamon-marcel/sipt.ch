<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseEventStudentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_event_student', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('course_event_id');
            $table->uuid('student_id');
            $table->foreign('course_event_id')->references('id')->on('course_events');
            $table->foreign('student_id')->references('id')->on('students');    
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
        Schema::dropIfExists('course_event_student');
    }
}
