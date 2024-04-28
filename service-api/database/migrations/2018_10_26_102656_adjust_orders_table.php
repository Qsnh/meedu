<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdjustOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('goods_id');
            $table->dropColumn('goods_type');
            $table->dropColumn('extra');

            $table->string('order_id', 18)->comment('订单编号');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('goods_id');
            $table->string('goods_type')->comment('商品类型');
            $table->string('extra', 512)->default('')->comment('额外信息');

            $table->dropColumn('order_id');
        });
    }
}
