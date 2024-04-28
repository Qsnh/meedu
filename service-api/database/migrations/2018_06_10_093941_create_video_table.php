<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('course_id');
            $table->string('title')->comment('标题');
            $table->string('slug')->comment('slug');
            $table->string('url')->default('')->comment('播放地址');
            $table->integer('view_num')->default(0)->comment('观看次数');

            $table->string('short_description')->default('')->comment('简短介绍');
            $table->text('description')->comment('详细介绍');

            $table->string('seo_keywords')->default('')->comment('SEO关键字');
            $table->string('seo_description')->default('')->comment('SEO描述');

            $table->timestamp('published_at')->default(null)->nullable(true)->comment('上线时间');
            $table->tinyInteger('is_show')->comment('1显示,-1隐藏');
            $table->softDeletes();
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
