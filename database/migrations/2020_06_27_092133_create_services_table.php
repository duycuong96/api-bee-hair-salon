<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('slugs', 255)->nullable();
            $table->text('detail')->nullable();
            $table->unsignedInteger('service_id');
            $table->json('images')->nullable();
            $table->unsignedBigInteger('price')->default(0);
            $table->unsignedInteger('sale_price')->default(0);
            $table->time('estimate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
