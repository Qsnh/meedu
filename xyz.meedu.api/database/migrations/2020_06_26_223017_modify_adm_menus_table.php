<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyAdmMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('administrator_menus', function (Blueprint $table) {
            $table->dropColumn('permission_id');
            $table->dropColumn('order');

            $table->string('permission')->default('')->comment('权限');
            $table->string('icon')->default('')->comment('icon');
            $table->integer('sort')->default(0)->comment('升序');
            $table->tinyInteger('is_super')->default(0)->comment('超管独有');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('administrator_menus', function (Blueprint $table) {
            $table->integer('permission_id')->default(0);
            $table->integer('order')->default(0);

            $table->dropColumn('permission');
            $table->dropColumn('icon');
            $table->dropColumn('sort');
            $table->dropColumn('is_super');
        });
    }
}
