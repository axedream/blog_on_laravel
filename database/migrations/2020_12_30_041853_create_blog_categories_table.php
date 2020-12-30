<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->unsigned()->default(1)->comment('Ссылка на родителя, если 1 то родителя нет');

            $table->string('slug')->unique()->comment('Название категории');
            $table->string('title')->comment('Название категории в транслите');
            $table->text('description')->nullable()->comment('Описание');

            $table->timestamps();

            $table->softDeletes()->comment('Время удаления записи');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_categories');
    }
}
