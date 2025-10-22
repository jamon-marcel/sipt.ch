<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDownloadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
	public function up()
	{
		Schema::create('downloads', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->string('title');
			$table->string('file')->nullable();
			$table->integer('order')->nullable()->default(-1);
			$table->tinyInteger('is_published')->default(0);
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
		Schema::dropIfExists('downloads');
	}
}
