<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDeleteJobs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_delete_jobs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0);
            $table->string('mobile', 24)->default('')->comment('手机号');
            $table->tinyInteger('is_handle')->default(0)->comment('是否处理');
            $table->timestamp('submit_at')->nullable(true)->default(null)->comment('申请时间');
            $table->timestamp('expired_at')->nullable(true)->default(null)->comment('过期时间');

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_delete_jobs');
    }
}
