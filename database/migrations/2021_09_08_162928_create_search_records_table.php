<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) 杭州白书科技有限公司
 */

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_records', function (Blueprint $table) {
            $table->id();
            $table->string('resource_type')->default('')->comment('资源类型');
            $table->bigInteger('resource_id')->default(0)->comment('资源ID');
            $table->string('title', 255)->default('')->comment('标题');
            $table->bigInteger('charge')->default(0)->comment('价格');
            $table->string('thumb', 255)->default('')->comment('封面');
            $table->string('short_desc', 255)->default('')->comment('简短介绍');
            $table->mediumText('desc')->nullable(true)->default(null)->comment('详细介绍');
            $table->timestamps();

            $table->index(['resource_id', 'resource_type'], 'rr_it');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_records');
    }
}
