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
    Schema::create('subscriptions', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('purchase_id');
      $table->foreign('purchase_id')->references('id')->on('purchases');
      $table->timestamp('start_date')->nullable()->default(null);
      $table->timestamp('end_date')->nullable()->default(null);
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
    Schema::dropIfExists('subscriptions');
  }
};
