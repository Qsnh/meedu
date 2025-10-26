<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class MigrateViewBlocksToDecorationPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 获取装修页面ID
        $h5PageId = DB::table('decoration_pages')
            ->where('page_key', 'h5-page-index')
            ->value('id');

        $pcPageId = DB::table('decoration_pages')
            ->where('page_key', 'pc-page-index')
            ->value('id');

        // 如果装修页面存在，则更新view_blocks关联
        if ($h5PageId) {
            DB::table('view_blocks')
                ->where('page', 'h5-page-index')
                ->update(['decoration_page_id' => $h5PageId]);
        }

        if ($pcPageId) {
            DB::table('view_blocks')
                ->where('page', 'pc-page-index')
                ->update(['decoration_page_id' => $pcPageId]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
