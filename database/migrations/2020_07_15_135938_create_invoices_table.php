<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->mediumInteger('number');
            $table->date('date');
            $table->string('file');
            $table->tinyInteger('state')->nullable();
            $table->tinyInteger('is_paid')->default(0);
            $table->uuid('student_id')->nullable();
            $table->foreign('student_id')->references('id')->on('students');
            $table->uuid('course_event_id')->nullable();
            $table->foreign('course_event_id')->references('id')->on('course_events');
            $table->uuid('symposium_subscriber_id')->nullable();
            $table->foreign('symposium_subscriber_id')->references('id')->on('symposium_subscribers');
            $table->uuid('symposium_id')->nullable();
            $table->foreign('symposium_id')->references('id')->on('symposiums');
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
        Schema::dropIfExists('invoices');
    }
}
