<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdministratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('firstname', 100);
            $table->string('name', 100);
            $table->string('street', 100);
            $table->string('street_no', 10);
            $table->string('zip', 10);
            $table->string('city', 100);
            $table->string('phone', 20);
            $table->string('mobile', 20)->nullable();
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
        Schema::dropIfExists('administrators');
    }
}
