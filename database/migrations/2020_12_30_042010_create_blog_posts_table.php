<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('category_id')->unsigned()->comment('Ссылка на категории');
            $table->integer('user_id')->unsigned()->comment('Ссылка на автора/пользователя');

            $table->string('slug')->unique();
            $table->string('title')->comment('Транслит для формирования URL');

            $table->text('excerpt')->nullable()->comment('Выдержка статьи/часть');

            $table->text('content_raw')->comment('Сырой контент MARKDOWN');
            $table->text('content_html')->comment('Контент в HTML/автогенерируется на основании content_raw');

            $table->boolean('is_published')->default(false)->comment('Опубликовано - TRUE, Не опубликовано - FALSE');
            $table->timestamp('published_at')->nullable()->comment('Дата публикации/по когда установили TRUE в поле is_published');

            $table->timestamps();
            $table->softDeletes()->comment('Мягкое удаление');

            //поле связи с таблицей blog_categories
            $table->foreign('category_id')->references('id')->on('blog_categories');

            //поле связи с таблицей users
            $table->foreign('user_id')->references('id')->on('users');

            //индекс на поле is_published
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_posts');
    }
}
