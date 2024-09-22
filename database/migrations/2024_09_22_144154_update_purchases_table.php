<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::table('purchases', function (Blueprint $table) {
      Schema::table('purchases', function (Blueprint $table) {
        $table->enum('payment_method', ['baridimob', 'poste', 'chargily'])->after('status');
      });
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    //
  }
};
