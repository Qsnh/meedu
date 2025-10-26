<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemovePlatformFromDecorationPages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('view_blocks', function (Blueprint $table) {
            $table->unsignedBigInteger('decoration_page_id')->nullable()->after('id')->comment('装修页面ID');
            $table->index('decoration_page_id', 'idx_decoration_page_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('view_blocks', function (Blueprint $table) {
            $table->dropIndex('idx_decoration_page_id');
            $table->dropColumn('decoration_page_id');
        });
    }
}
