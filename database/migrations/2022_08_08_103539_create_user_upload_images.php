<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserUploadImages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\App\Constant\TableConstant::TABLE_USER_UPLOAD_IMAGES, function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0)->comment('上传者userId可能为0');
            $table->string('group', 16)->default('')->comment('分组');

            $table->string('disk', 16)->default('')->comment('存储磁盘');
            $table->string('path', 255)->default('')->comment('存储路径');
            $table->string('name', 255)->default('')->comment('文件名');
            $table->string('visit_url', 255)->default('')->comment('访问地址');

            $table->string('log_api', 255)->default('')->comment('上传的api');
            $table->ipAddress('log_ip')->default('')->comment('上传者ip地址');
            $table->string('log_ua', 255)->default('')->comment('上传者的UA');

            $table->timestamp('created_at')->nullable(true)->default(null);

            $table->index(['group']);
            $table->index(['disk']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(\App\Constant\TableConstant::TABLE_USER_UPLOAD_IMAGES);
    }
}
