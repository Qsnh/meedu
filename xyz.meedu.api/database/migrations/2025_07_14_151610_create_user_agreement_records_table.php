<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAgreementRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_user_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('用户ID');
            $table->bigInteger('agreement_id')->comment('协议ID');
            $table->string('agreement_type', 50)->comment('协议类型');
            $table->string('agreement_version', 50)->comment('协议版本');
            $table->timestamp('agreed_at')->comment('同意时间');
            $table->string('ip', 64)->default('')->comment('IP地址');
            $table->text('user_agent')->nullable()->comment('User-Agent信息');
            $table->string('platform', 20)->default('')->comment('平台：PC,H5,iOS,Android,Mini');
            $table->timestamps();

            $table->index(['user_id'], 'idx_user_id');
            $table->index(['agreement_type'], 'idx_agreement_type');
            $table->index(['agreed_at'], 'idx_agreed_at');
            $table->unique(['user_id', 'agreement_id'], 'uk_user_agreement');
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
        Schema::dropIfExists('agreement_user_records');
    }
}
