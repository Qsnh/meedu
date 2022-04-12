<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsOpenForMediaVideos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('media_videos', function (Blueprint $table) {
            $table->tinyInteger('is_open')->default(0)->comment('开放[0:否,1:是].开放的话则可以公开播放');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('media_videos', function (Blueprint $table) {
            $table->dropColumn('is_open');
        });
    }
}
