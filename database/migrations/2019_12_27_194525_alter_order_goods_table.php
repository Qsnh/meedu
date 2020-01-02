<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterOrderGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_goods', function (Blueprint $table) {
            $table->dropUnique('order_goods_order_id_unique');
            $table->integer('oid')->unsigned()->nullable(false)->comment('订单id')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_goods', function (Blueprint $table) {
            $table->dropColumn('oid');
        });
    }
}
