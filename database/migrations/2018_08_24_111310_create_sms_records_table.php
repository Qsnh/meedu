<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSmsRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile')->comment('手机号');
            $table->text('send_data')->nullable(true)->default('')->comment('发送数据');
            $table->text('response_date')->nullable(true)->default('')->comment('响应数据');
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
        Schema::dropIfExists('sms_records');
    }
}
