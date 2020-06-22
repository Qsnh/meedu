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

class CreateUserVideoWatchRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_video_watch_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->integer('course_id');
            $table->integer('video_id');
            $table->integer('watch_seconds')->default(0)->comment('已观看秒数');
            $table->timestamp('watched_at')->nullable(true)->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'course_id', 'video_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_video_watch_records');
    }
}
