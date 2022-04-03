<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRefundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_refund', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id')->default(0)->comment('关联的订单表id');
            $table->bigInteger('user_id')->default(0)->comment('关联的用户id');

            // 订单的基础信息
            $table->string('payment', 32)->default('')->comment('支付渠道[wechat,alipay,handPay]');
            $table->integer('total_amount')->default(0)->comment('订单支付金额，单位：分');

            // 退款订单信息
            $table->string('refund_no', 32)->unique()->comment('本地退款单号');
            $table->integer('amount')->default(0)->comment('退款金额，单位：分');
            $table->string('reason', 64)->default('')->comment('退款原因');
            $table->tinyInteger('is_local')->default(0)->comment('是否为本地退款记录[1:是,0:否]');
            $table->tinyInteger('status')->default(0)->comment('状态[1:受理中,5:成功,9:异常,13:已关闭]');
            $table->timestamp('success_at')->nullable(true)->default(null)->comment('成功时间');

            $table->timestamps();

            $table->index(['order_id'], 'order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_refund');
    }
}
