<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGoodsColumnForOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_goods', function (Blueprint $table) {
            $table->string('goods_name', 255)->default('')->comment('商品名');
            $table->string('goods_thumb', 255)->default('')->comment('商品封面');
            $table->integer('goods_charge')->default(0)->comment('商品标价');
            $table->integer('goods_ori_charge')->default(0)->comment('商品原价');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
