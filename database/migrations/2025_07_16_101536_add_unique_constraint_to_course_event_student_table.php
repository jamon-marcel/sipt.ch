<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('course_event_student', function (Blueprint $table) {
            $table->unique(['course_event_id', 'student_id', 'deleted_at'], 'ces_unique_constraint');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_event_student', function (Blueprint $table) {
            $table->dropUnique('ces_unique_constraint');
        });
    }
};
