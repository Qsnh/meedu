<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInviteBalanceWithdrawRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ib_withdraw_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('total')->comment('提现金额,单位：元');
            $table->integer('before_balance')->default(0)->comment('提现前账户余额');
            $table->tinyInteger('status')->default(0)->comment('状态,0已提交,1提现成功,2拒绝');
            $table->string('channel')->comment('提现渠道');
            $table->string('channel_name')->comment('渠道姓名');
            $table->string('channel_account')->comment('渠道账号');
            $table->string('channel_address')->comment('渠道地址');
            $table->string('remark')->nullable(true)->comment('备注');
            $table->timestamps();
            $table->softDeletes();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_ib_withdraw_orders');
    }
}
