<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookChapterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('book_chapters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_id');
            $table->integer('user_id');
            $table->string('title')->comment('章节名');
            $table->text('content')->comment('内容');
            $table->integer('view_num')->default(0)->comment('浏览次数');
            $table->timestamp('published_at')->default(null)->nullable(true)->comment('发布时间');
            $table->tinyInteger('is_show')->comment('1显示,-1隐藏');
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
        Schema::dropIfExists('book_chapters');
    }
}