<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPaidRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_paid_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->integer('order_id')->default(0)->comment('订单id');
            $table->integer('paid_total')->default(0)->comment('支付金额');
            $table->tinyInteger('paid_type')->default(0)->comment('支付类型，0默认支付,1优惠码,2余额支付');
            $table->integer('paid_type_id')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_paid_records');
    }
}
