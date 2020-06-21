<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseAttachTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_attach', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('course_id');
            $table->string('name')->default('')->comment('附件名');
            $table->string('path')->default('')->comment('路径');
            $table->string('disk', 12)->default('')->comment('存储磁盘');
            $table->integer('size')->default(0)->comment('单位：byte');
            $table->string('extension', 12)->default('')->comment('文件格式');
            $table->tinyInteger('only_buyer')->default(1)->comment('只有购买者可以下载,1是,0否');
            $table->integer('download_times')->default(0)->comment('下载次数');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['course_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_attach');
    }
}
