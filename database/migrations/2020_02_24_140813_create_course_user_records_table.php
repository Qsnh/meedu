<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseUserRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_user_records', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('course_id');
            $table->integer('user_id');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['user_id']);
            $table->index(['course_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_user_records');
    }
}
