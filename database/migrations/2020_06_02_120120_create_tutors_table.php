<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('firstname', 100);
            $table->string('name', 100);
            $table->string('title', 100)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('street_no', 100)->nullable();
            $table->string('zip', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('mobile', 254)->nullable();
            $table->longText('bio')->nullable();  
            $table->tinyInteger('is_published')->default(0);
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('tutors');
    }
}
