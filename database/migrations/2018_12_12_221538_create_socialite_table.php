<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialiteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socialite', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('app');
            $table->string('app_user_id');
            $table->string('data', 2222);
            $table->timestamps();

            $table->index(['app', 'app_user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('socialite');
    }
}
