<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gallery', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->integer('cat')->nullable();
            $table->string('image')->nullable();
            $table->text('caption')->nullable();
            $table->string('link_to')->nullable();
            $table->string('page_title')->nullable();
            $table->text('meta_des')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->string('meta_page_topic')->nullable();
            $table->boolean('public')->nullable();
            $table->boolean('new')->nullable();
            $table->boolean('highlight')->nullable();
            $table->string('slug')->nullable();

            $table->string('language')->nullable();
            $table->integer('order')->nullable();
            $table->integer('updated_by')->nullable();

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
        Schema::dropIfExists('gallery');
    }
}
