<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnniversaryRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('anniversary_registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('number')->nullable();
            $table->string('booking_number', 20)->nullable();
            $table->string('salutation', 50);
            $table->string('firstname', 100);
            $table->string('name', 100);
            $table->string('title', 100)->nullable();
            $table->string('email', 200);
            $table->string('phone', 100)->nullable();
            $table->string('street', 100);
            $table->string('street_no', 20);
            $table->string('zip', 20);
            $table->string('city', 100);
            $table->string('ticket_type', 50); // both_days, friday_only, saturday_only
            $table->decimal('cost', 10, 2)->default(0);
            $table->tinyInteger('apero_friday')->default(0);
            $table->tinyInteger('lunch_saturday')->default(0);
            $table->tinyInteger('is_early_bird')->default(0);
            $table->tinyInteger('is_billed')->default(0);
            $table->tinyInteger('is_paid')->default(0);
            $table->tinyInteger('is_cancelled')->default(0);
            $table->uuid('user_id')->nullable();
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
        Schema::dropIfExists('anniversary_registrations');
    }
}
