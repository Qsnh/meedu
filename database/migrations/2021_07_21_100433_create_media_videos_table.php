<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255)->default('')->comment('视频名');
            $table->string('thumb', 255)->default('')->comment('封面');
            $table->integer('duration')->default(0)->comment('时长');
            $table->integer('size')->default(0)->comment('视频大小，单位：字节');

            $table->string('storage_driver', 32)->default('')->comment('存储驱动');
            $table->string('storage_file_id', 255)->default('')->comment('存储特征值');

            $table->tinyInteger('transcode_status')->default(0)->comment('0未转码,3转码中,5转码成功,7转码失败');

            $table->integer('ref_count')->default(0)->comment('引用次数');

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
        Schema::dropIfExists('media_videos');
    }
}
