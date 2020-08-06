<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchSalonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_salons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index('name');
            $table->string('thumb_img');
            $table->text('content')->nullable();
            $table->json('work_time')->nullable();
            $table->string('address');
            $table->bigInteger('view')->nullable();
            $table->integer('ward_id')->nullable();
            $table->bigInteger('admin_id')->nullable();
            $table->json('locations')->nullable();
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
        Schema::dropIfExists('branch_salons');
    }
}
