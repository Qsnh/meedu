<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSceneAndIsHideAndCategoryIdForMediaImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Constant\TableConstant::MEDIA_IMAGES, function (Blueprint $table) {
            $table->integer('category_id')->default(0)->comment('分类id');
            $table->tinyInteger('is_hide')->default(0)->comment('列表隐藏[1:是,0:否]');
            $table->string('scene', 20)->default('')->comment('来源场景[avatar:头像,verify:认证,cover:封面,editor:富文本]');
            $table->string('operator', 32)->default('')->comment('操作人');
            $table->string('operator_id', 12)->default('')->comment('操作人ID[格式:a-%d,u-%d]=>a=后台管理,u=学员,t=讲师');

            $table->index(['category_id'], 'cid');
            $table->index(['scene'], 'scene');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Constant\TableConstant::MEDIA_IMAGES, function (Blueprint $table) {
            $table->dropIndex('cid');
            $table->dropIndex('scene');

            $table->dropColumn('category_id');
            $table->dropColumn('is_hide');
            $table->dropColumn('scene');
            $table->dropColumn('operator');
            $table->dropColumn('operator_id');
        });
    }
}
