<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsVerifyForUserProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Constant\TableConstant::TABLE_USER_PROFILES, function (Blueprint $table) {
            $table->tinyInteger('is_verify')->default(0)->comment('实名认证[0:否,1:是]');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Constant\TableConstant::TABLE_USER_PROFILES, function (Blueprint $table) {
            $table->dropColumn('is_verify');
        });
    }
}
