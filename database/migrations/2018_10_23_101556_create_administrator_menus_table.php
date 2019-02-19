<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdministratorMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('administrator_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id');
            $table->integer('order')->default(1)->comment('升序');
            $table->integer('permission_id')->comment('权限');
            $table->string('name')->comment('链接');
            $table->string('url')->comment('地址');
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
        Schema::dropIfExists('administrator_menus');
    }
}
