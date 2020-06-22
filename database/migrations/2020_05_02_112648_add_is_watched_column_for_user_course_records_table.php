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

class AddIsWatchedColumnForUserCourseRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('course_user_records', function (Blueprint $table) {
            $table->tinyInteger('is_watched')->default(0)->comment('看完,0否,1是');
            $table->timestamp('watched_at')->nullable(true)->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('course_user_records', function (Blueprint $table) {
            $table->dropColumn('is_watched');
            $table->dropColumn('watched_at');
        });
    }
}
