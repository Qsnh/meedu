<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIpForCourseComment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(\App\Constant\TableConstant::TABLE_COURSE_COMMENTS, function (Blueprint $table) {
            $table->string('ip', 15)->default('');
            $table->string('ip_province', 32)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(\App\Constant\TableConstant::TABLE_COURSE_COMMENTS, function (Blueprint $table) {
            $table->dropColumn('ip');
            $table->dropColumn('ip_province');
        });
    }
}
