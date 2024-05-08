<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateViewBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('view_blocks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('platform', 32)->default('')->comment('平台');
            $table->string('page', 32)->default('')->comment('所属页面');
            $table->string('sign', 64)->default('')->comment('标识');
            $table->integer('sort')->default(0)->comment('升序');
            $table->mediumText('config')->nullable(true)->default(null)->comment('配置内容');
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
        Schema::dropIfExists('view_blocks');
    }
}
