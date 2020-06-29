<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSymposiumSubscribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('symposium_subscribers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('firstname', 100);
            $table->string('name', 100);
            $table->string('title', 200)->nullable();
            $table->string('street', 100);
            $table->string('street_no', 10);
            $table->string('city', 100);
            $table->string('phone', 100);
            $table->string('phone_business', 200)->nullable();
            $table->string('mobile', 200)->nullable();
            $table->string('email', 200)->unique();
            $table->string('qualifications', 200);
            $table->tinyInteger('needs_credit_confirmation')->default(0);
            $table->tinyInteger('has_attendance')->default(0);
            $table->uuid('user_id')->nullable();
            $table->uuid('symposium_id');
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
        Schema::dropIfExists('symposium_subscribers');
    }
}
