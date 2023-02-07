<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFaceVerifyTencentRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_face_verify_tencent_records', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0)->comment('用户ID');
            $table->string('rule_id', 32)->default('')->comment('认证的规则ID');
            $table->string('request_id', 128)->default('')->comment('requestId');
            $table->string('url', 2550)->default('')->comment('实名认证URL');
            $table->string('biz_token', 128)->default('')->comment('bizToken');
            $table->tinyInteger('status')->default(0)->comment('状态[0:已提交,5:未通过,9:已通过]');
            $table->string('verify_image_url', 255)->default('')->comment('认证结果图片URL');
            $table->string('verify_video_url', 255)->default('')->comment('认证结果视频URL');
            $table->timestamps();

            $table->unique('biz_token');
            $table->index('user_id', 'user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_face_verify_tencent_records');
    }
}
