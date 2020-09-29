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

class CreateUserWatchStatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_watch_stat', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->default(0)->comment('用户id');
            $table->mediumInteger('year')->default(0)->comment('年份');
            $table->tinyInteger('month')->default(0)->comment('月份');
            $table->tinyInteger('day')->default(0)->comment('日');
            $table->integer('seconds')->default(0)->comment('观看秒数');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'year', 'month', 'day'], 'u_ymd');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_watch_stat');
    }
}
