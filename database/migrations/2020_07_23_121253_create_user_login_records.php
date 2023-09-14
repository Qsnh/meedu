<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLoginRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\App\Constant\TableConstant::TABLE_USER_LOGIN_RECORDS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('ip')->default('')->comment('ip');
            $table->string('area')->default('')->comment('区域');
            $table->timestamp('at')->nullable(true)->default(null)->comment('时间');
            $table->string('platform')->default('')->comment('平台,pc,h5,mini,app等等');
            $table->timestamps();

            $table->index(['user_id']);

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(\App\Constant\TableConstant::TABLE_USER_LOGIN_RECORDS);
    }
}
