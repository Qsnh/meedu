<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIndexBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('index_banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('banner名称');
            $table->integer('sort')->comment('升序');
            $table->string('course_ids')->comment('课程id,英文逗号分隔');
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
        Schema::dropIfExists('index_banners');
    }
}
