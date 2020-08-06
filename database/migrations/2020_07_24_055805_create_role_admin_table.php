<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_admin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('role_id')->unsigned();
            $table->bigInteger('admin_id')->unsigned();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('admin_id')->references('id')->on('admin');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('role_admin', function(Blueprint $table){
            $table->dropForeign(['role_id']);
            $table->dropForeign(['admin_id']);
        });
        Schema::dropIfExists('role_admin');
    }
}
