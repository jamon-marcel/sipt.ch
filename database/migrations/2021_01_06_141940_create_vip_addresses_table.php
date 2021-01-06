<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVipAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vip_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('firstname', 100);
            $table->string('name', 100);
            $table->string('title', 100)->nullable();
            $table->string('role', 100)->nullable();
            $table->string('company', 100)->nullable();
            $table->string('department', 100)->nullable();
            $table->string('street', 100)->nullable();
            $table->string('street_no', 100)->nullable();
            $table->string('address_extra', 100)->nullable();
            $table->string('zip', 100)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('email')->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('mobile', 254)->nullable();
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
        Schema::dropIfExists('vip_addresses');
    }
}
