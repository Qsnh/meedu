<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMainUrlColumnForAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('addons', function (Blueprint $table) {
            $table->string('main_url')->nullable(true)->comment('创建主链接');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('addons', function (Blueprint $table) {
            $table->dropColumn('main_url');
        });
    }
}
