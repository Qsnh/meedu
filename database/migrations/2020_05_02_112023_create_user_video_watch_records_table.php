<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserVideoWatchRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\App\Constant\TableConstant::TABLE_USER_VIDEO_WATCH_RECORDS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('course_id');
            $table->integer('video_id');
            $table->integer('watch_seconds')->default(0)->comment('已观看秒数');
            $table->timestamp('watched_at')->nullable(true)->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'course_id', 'video_id']);

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
        Schema::dropIfExists(\App\Constant\TableConstant::TABLE_USER_VIDEO_WATCH_RECORDS);
    }
}
