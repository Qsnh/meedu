<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderRemoteRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_remote_relation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('order_id', 18)->unique()->comment('订单号');
            $table->string('remote_id')->comment('第三方平台的订单ID');
            $table->string('payment')->comment('支付平台');
            $table->text('create_data')->comment('第三方支付平台创建返回的数据');
            $table->text('callback_data')->comment('第三方支付平台回调的数据');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_remote_relation');
    }
}
