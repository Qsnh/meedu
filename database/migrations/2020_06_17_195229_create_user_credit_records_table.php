<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCreditRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(\App\Constant\TableConstant::TABLE_USER_CREDIT_RECORDS, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            $table->string('field')->default('')->comment('字段');
            $table->integer('sum')->default(0)->comment('变动额度');
            $table->string('remark')->default('')->comment('变动说明');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id', 'field']);

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
        Schema::dropIfExists(\App\Constant\TableConstant::TABLE_USER_CREDIT_RECORDS);
    }
}
