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
    Schema::create('ads', function (Blueprint $table) {
      $table->id();
      $table->string('name')->nullable()->default(null);
      $table->string('image');
      $table->string('url')->nullable();
      $table->enum('type', ['url', 'teacher', 'course']);
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
    Schema::dropIfExists('ads');
  }
};
