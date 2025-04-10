<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0)->comment('父ID');
            $table->integer('reply_id')->default(0)->comment('回复的ID');
            $table->integer('user_id')->default(0)->comment('用户ID');
            $table->integer('rt')->default(0)->comment('资源类型[0:录播课,1:录播课课时]');
            $table->integer('rid')->default(0)->comment('资源ID');
            $table->text('content')->nullable()->default(null)->comment('评论内容');
            $table->string('ip', 15)->default('')->comment('IP');
            $table->string('ip_province', 32)->default('')->comment('IP所属省份');
            $table->tinyInteger('is_check')->default(0)->comment('1:审核通过,0:拒绝');
            $table->string('check_reason', 32)->default('')->comment('审核原因');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['rt', 'rid', 'parent_id'], 'r_r_p');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
