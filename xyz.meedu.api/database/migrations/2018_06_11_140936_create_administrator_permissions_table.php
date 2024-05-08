<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrator_permissions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('display_name')->comment('权限名');
            $table->string('slug')->comment('slug');
            $table->string('description')->comment('描述');
            $table->string('method')->comment('HTTP动作');
            $table->string('url')->comment('URL');
            $table->timestamps();

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
        Schema::dropIfExists('administrator_permissions');
    }
}
