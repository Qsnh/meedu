<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseAttachDownloadRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_attach_download_records', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0)->comment('学员ID');
            $table->integer('course_id')->default(0)->comment('录播课ID');
            $table->integer('attach_id')->default(0)->comment('附件ID');
            $table->string('ip', 15)->nullable()->default(null)->comment('下载IP');
            $table->string('ip_area')->default('')->comment('IP转换为地域');
            $table->timestamp('created_at')->nullable()->default(null)->comment('创建时间');

            $table->index(['user_id', 'course_id'], 'u_c');
            $table->index(['course_id', 'attach_id'], 'a_c');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_attach_download_records');
    }
}
