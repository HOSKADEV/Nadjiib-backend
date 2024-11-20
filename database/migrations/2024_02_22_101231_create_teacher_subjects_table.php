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
    Schema::create('teacher_subjects', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('teacher_id');
      $table->foreign('teacher_id')->references('id')->on('teachers');
      $table->unsignedBigInteger('subject_id');
      $table->foreign('subject_id')->references('id')->on('subjects');
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
    Schema::dropIfExists('teacher_subjects');
  }
};
