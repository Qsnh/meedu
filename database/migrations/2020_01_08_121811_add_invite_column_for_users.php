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

class AddInviteColumnForUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('invite_balance')->default(0)->comment('邀请奖励余额');
            $table->integer('invite_user_id')->default(0)->comment('邀请人id');
            $table->timestamp('invite_user_expired_at')->nullable(true)->comment('邀请过期时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('invite_balance');
            $table->dropColumn('invite_user_id');
            $table->dropColumn('invite_user_expired_at');
        });
    }
}
