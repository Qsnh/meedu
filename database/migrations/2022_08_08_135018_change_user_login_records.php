<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserLoginRecords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Constant\TableConstant::TABLE_USER_LOGIN_RECORDS, function (Blueprint $table) {
            $table->dropColumn('area');
            $table->dropColumn('at');

            $table->string('ua', 255)->default('');
            $table->string('token', 1024)->default('')->comment('登录token');
            $table->string('iss', 255)->default('')->comment('token发行url');
            $table->integer('exp')->default(0);
            $table->string('jti', 32)->default('')->comment('tokenID');
            $table->tinyInteger('is_logout')->default(0)->comment('是否注销[1:是,0否]');

            $table->index(['jti'], 'jti');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Constant\TableConstant::TABLE_USER_LOGIN_RECORDS, function (Blueprint $table) {
            $table->dropIndex('jti');

            $table->dropColumn('ua');
            $table->dropColumn('token');
            $table->dropColumn('iss');
            $table->dropColumn('exp');
            $table->dropColumn('jti');
            $table->dropColumn('is_logout');

            $table->string('area', 32)->default('');
            $table->timestamp('at')->default(null)->nullable(true);
        });
    }
}
