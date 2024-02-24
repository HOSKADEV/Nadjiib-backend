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
    Schema::create('purchases', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('student_id');
      $table->foreign('student_id')->references('id')->on('students');
      $table->unsignedBigInteger('course_id');
      $table->foreign('course_id')->references('id')->on('courses');
      $table->double('price')->default(0.0);
      $table->double('total')->default(0.0);
      $table->enum('status', ['pending', 'failed', 'success']);
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
    Schema::dropIfExists('purchases');
  }
};
