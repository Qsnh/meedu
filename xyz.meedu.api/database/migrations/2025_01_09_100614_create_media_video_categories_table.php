<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaVideoCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_video_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 128)->default('')->comment('分类名');
            $table->integer('sort')->default(0)->comment('升序');
            $table->integer('admin_id')->default(0)->comment('创建的管理员ID');
            $table->integer('parent_id')->default(0)->comment('父类id');
            $table->string('parent_chain', 255)->default(0)->comment('父链');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media_video_categories');
    }
}
