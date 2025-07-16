<?php

/*
 * This file is part of the MeEdu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAgreementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type', 50)->comment('协议类型：user_agreement,privacy_policy,vip_service_agreement');
            $table->string('title')->comment('协议标题');
            $table->longText('content')->comment('协议内容');
            $table->string('version', 50)->comment('版本号');
            $table->tinyInteger('is_active')->default(0)->comment('是否为当前生效版本：1=是，0=否');
            $table->timestamp('effective_at')->nullable()->comment('生效时间');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['type'], 'idx_type');
            $table->index(['is_active'], 'idx_is_active');
            $table->index(['effective_at'], 'idx_effective_at');
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
        Schema::dropIfExists('agreements');
    }
}
