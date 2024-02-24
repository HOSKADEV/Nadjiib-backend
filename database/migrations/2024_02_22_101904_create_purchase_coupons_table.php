<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('purchase_coupons', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('purchase_id');
      $table->foreign('purchase_id')->references('id')->on('purchases');
      $table->unsignedBigInteger('coupon_id');
      $table->foreign('coupon_id')->references('id')->on('coupons');
      $table->double('discount_amount');
      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('purchase_coupons');
  }
};
