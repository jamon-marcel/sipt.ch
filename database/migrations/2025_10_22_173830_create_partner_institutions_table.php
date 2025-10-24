<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartnerInstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('partner_institutions', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->string('name');
			$table->text('description')->nullable();
			$table->integer('order')->nullable()->default(-1);
			$table->tinyInteger('is_published')->default(0);
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('partner_institutions');
	}
}
