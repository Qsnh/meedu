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

class CreateUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unique()->default(0)->comment('用户id');
            $table->string('real_name', 32)->default('')->comment('真实姓名');
            $table->tinyInteger('age')->default(0)->comment('年龄');
            $table->string('gender', 10)->default('')->comment('性别');
            $table->string('birthday')->default('')->comment('生日');
            $table->string('profession', 64)->default('')->comment('职业');
            $table->string('address', 255)->default('')->comment('住址');
            $table->string('graduated_school', 128)->default('')->comment('毕业院校');
            $table->string('diploma', 255)->default('')->comment('毕业证书');
            $table->string('id_number', 32)->default('')->comment('身份证号');
            $table->string('id_frontend_thumb', 255)->default('')->comment('身份证正面照');
            $table->string('id_backend_thumb', 255)->default('')->comment('身份证反面照');
            $table->string('id_hand_thumb', 255)->default('')->comment('手持身份证照');
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
        Schema::dropIfExists('user_profiles');
    }
}
