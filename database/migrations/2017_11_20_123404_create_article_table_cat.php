<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTableCat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_cat', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');
            $table->integer('parent')->nullable();
            $table->string('image')->nullable();
            $table->text('des')->nullable();            
            $table->string('page_title')->nullable();
            $table->text('meta_des')->nullable();
            $table->text('meta_keyword')->nullable();
            $table->string('meta_page_topic')->nullable();            
            $table->boolean('highlight')->nullable();
            $table->string('slug')->nullable();
            $table->string('language')->nullable();
            $table->integer('order')->nullable();
            $table->integer('view_count')->nullable();
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
        Schema::dropIfExists('article_cat');
    }
}
