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
        Schema::table('purchase_coupons', function (Blueprint $table) {
          $table->dropColumn('discount_amount');
          $table->double('percentage')->default(0)->after('coupon_id');
          $table->double('amount')->default(0)->after('percentage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_coupons', function (Blueprint $table) {
            //
        });
    }
};
