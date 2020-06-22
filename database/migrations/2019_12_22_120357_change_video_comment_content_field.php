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

class ChangeVideoCommentContentField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('video_comments', function (Blueprint $table) {
            // 删除content字段
            $table->dropColumn('content');

            // 新建content字段
            $table->text('original_content')->comment('原始内容')->after('video_id');
            $table->text('render_content')->comment('渲染后的内容')->after('original_content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('video_comments', function (Blueprint $table) {
            // 删除content字段
            $table->dropColumn('original_content');
            $table->dropColumn('render_content');

            // 新建content字段
            $table->text('content')->comment('内容')->after('video_id');
        });
    }
}
