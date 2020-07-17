<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterCourseEventStudentTableAddIsCancelledDateCancelled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_event_student', function (Blueprint $table) {
            $table->date('cancelled_at')->nullable()->after('booking_number');
            $table->tinyInteger('is_cancelled')->default(0)->after('is_billed');
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
