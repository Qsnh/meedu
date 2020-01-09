<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0)->comment('用户id');
            $table->string('code', 24)->unique()->comment('优惠码');
            $table->timestamp('expired_at')->nullable(true)->comment('过期时间');
            $table->integer('invite_user_reward')->default(0)->comment('邀请用户奖励');
            $table->integer('invited_user_reward')->default(0)->comment('邀请用户奖励');
            $table->integer('use_times')->default(0)->comment('可使用次数，0表示不限制');
            $table->integer('used_times')->default(0)->comment('已使用次数');
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
        Schema::dropIfExists('promo_codes');
    }
}
