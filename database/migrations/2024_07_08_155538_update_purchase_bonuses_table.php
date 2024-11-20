<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchase_bonuses', function (Blueprint $table) {
            $table->dropColumn('bonus_amount');
            $table->smallInteger('type')->default(0)->after('purchase_id');
            $table->double('percentage')->default(0)->after('type');
            $table->double('amount')->default(1)->after('percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_bonuses', function (Blueprint $table) {
            //
        });
    }
};
