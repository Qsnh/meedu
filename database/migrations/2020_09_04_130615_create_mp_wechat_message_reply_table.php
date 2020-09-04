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

class CreateMpWechatMessageReplyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mp_wechat_message_reply', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('type', 32)->default('')->comment('消息类型');
            $table->string('event_type', 32)->default('')->comment('事件类型[可选]');
            $table->string('event_key')->default('')->comment('事件key[可选]');
            $table->string('rule', 255)->default('')->comment('匹配规则');
            $table->string('reply_content', 5120)->default('')->comment('回复内容');

            $table->integer('hit_times')->default(0)->comment('命中次数');
            $table->timestamp('last_hit_at')->nullable(true)->default(null)->comment('最后一次命中时间');

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
        Schema::dropIfExists('mp_wechat_message_reply');
    }
}
