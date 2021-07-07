<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAdmPermissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('administrator_permissions', function (Blueprint $table) {
            $table->string('route')->default('')->comment('类型');
            $table->string('group_name')->default('')->comment('分组');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('administrator_permissions', function (Blueprint $table) {
            $table->dropColumn('route');
            $table->dropColumn('group_name');
        });
    }
}
