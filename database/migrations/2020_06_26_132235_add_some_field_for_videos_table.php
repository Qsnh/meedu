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

class AddSomeFieldForVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->tinyInteger('comment_status')->default(0)->comment('0禁止评论,1所有人,2仅购买');
            $table->mediumInteger('free_seconds')->default(0)->comment('试看秒数');
            $table->string('player_pc', 24)->default('')->comment('pc播放器');
            $table->string('player_h5', 24)->default('')->comment('h5播放器');
            $table->tinyInteger('ban_drag')->default(0)->comment('禁止拖动,0否,1是');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('comment_status');
            $table->dropColumn('free_seconds');
            $table->dropColumn('player_pc');
            $table->dropColumn('player_h5');
            $table->dropColumn('ban_drag');
        });
    }
}
