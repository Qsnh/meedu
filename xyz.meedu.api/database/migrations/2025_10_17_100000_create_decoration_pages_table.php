<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDecorationPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('decoration_pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 64)->default('')->comment('页面名称');
            $table->string('page_key', 64)->default('')->comment('页面唯一标识');
            $table->tinyInteger('is_default')->default(0)->comment('是否默认使用[0否,1是]');
            $table->timestamps();
        });

        // 插入默认数据
        \Illuminate\Support\Facades\DB::table('decoration_pages')->insert([
            [
                'name' => 'PC首页',
                'page_key' => 'pc-page-index',
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'H5首页',
                'page_key' => 'h5-page-index',
                'is_default' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('decoration_pages');
    }
}
