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
    Schema::create('payments', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('purchase_id');
      $table->foreign('purchase_id')->references('id')->on('purchases');
      $table->double('amount');
      $table->enum('type', ['received', 'made']);
      $table->enum('is_paid', ['yes', 'no']);
      $table->timestamp('paid_at')->nullable()->default(null);
      $table->enum('is_confirmed', ['yes', 'no']);
      $table->timestamp('confirmed_at')->nullable()->default(null);
      $table->enum('payment_method', ['card', 'cash'])->nullable()->default(null);
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
    Schema::dropIfExists('payments');
  }
};
