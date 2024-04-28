<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrator_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id')->default(0)->comment('管理员ID');
            $table->string('module', 32)->default('')->comment('模块');
            $table->string('opt', 32)->default('')->comment('操作指令');
            $table->mediumText('remark')->nullable(true)->default(null)->comment('备注');
            $table->ipAddress('ip')->default('')->comment('操作ip');
            $table->timestamp('created_at')->nullable(true)->default(null);

            $table->index(['admin_id', 'module', 'opt'], 'a_m_o');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('administrator_logs');
    }
}
