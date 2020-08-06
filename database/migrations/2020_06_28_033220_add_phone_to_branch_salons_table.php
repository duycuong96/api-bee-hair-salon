<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneToBranchSalonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('branch_salons', function (Blueprint $table) {
            $table->unsignedInteger('status')->default(0)->after('view');
            $table->string('phone', 14)->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('branch_salons', function (Blueprint $table) {
            $table->dropColumn(['status', 'phone']);
        });
    }
}
