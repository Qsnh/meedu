<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from')->default(0)->comment('上传来源');
            $table->string('name', 255)->default('')->comment('文件名');
            $table->string('url', 255)->default('')->comment('URL地址');
            $table->string('path', 255)->default('')->comment('相对地址');
            $table->string('disk', 64)->default('')->comment('存储磁盘');
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
        Schema::dropIfExists('media_images');
    }
}
