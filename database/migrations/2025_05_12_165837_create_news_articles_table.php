<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_articles', function (Blueprint $table) {
          $table->uuid('id')->primary();
          $table->string('title')->nullable();
          $table->string('date')->nullable();
          $table->text('text');
          $table->string('link')->nullable();
          $table->integer('order')->nullable()->default(-1);
          $table->tinyInteger('is_published')->default(0);
          $table->uuid('tutor_id')->nullable();
          $table->foreign('tutor_id')->references('id')->on('tutors');
          $table->uuid('category_id');
          $table->foreign('category_id')->references('id')->on('news_categories');
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
        Schema::dropIfExists('news_articles');
    }
}
