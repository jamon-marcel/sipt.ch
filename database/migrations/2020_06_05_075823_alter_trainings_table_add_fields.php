<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTrainingsTableAddFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trainings', function (Blueprint $table) {
            $table->longText('supervision')->after('structure')->nullable();  
            $table->longText('thesis')->after('supervision')->nullable();  
            $table->longText('certification')->after('thesis')->nullable();  
            $table->longText('teachingTime')->after('certification')->nullable();
            $table->uuid('location_id')->after('teachingTime')->nullable();
            
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
