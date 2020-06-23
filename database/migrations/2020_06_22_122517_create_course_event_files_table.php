<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseEventFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_event_files', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('caption', 200)->nullable();
            $table->double('size', 6, 2);
            $table->uuid('tutor_id')->nullable();
            $table->uuid('course_event_id');
            $table->foreign('course_event_id')->references('id')->on('course_events')->onDelete('cascade');
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
        Schema::dropIfExists('course_event_files');
    }
}
