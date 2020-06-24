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

class CreateWebconfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_config', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('group', 24)->default('')->comment('分组');
            $table->string('name', 24)->default('')->comment('名称');
            $table->integer('sort')->default(0)->comment('升序');
            $table->string('field_type', 24)->default('')->default('字段类型');
            $table->string('key', 188)->default('')->comment('键')->unique();
            $table->longText('value')->nullable(true)->default(null)->comment('值');
            $table->longText('default_value')->nullable(true)->default(null)->comment('默认值');
            $table->text('option_value')->nullable(true)->default(null)->comment('可选值');
            $table->tinyInteger('is_private')->default(0)->comment('是否私密信息');
            $table->string('help')->default('')->comment('帮助信息');
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
        Schema::dropIfExists('app_config');
    }
}
