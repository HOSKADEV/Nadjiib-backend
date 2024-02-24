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
    Schema::create('calls', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('teacher_id');
      $table->foreign('teacher_id')->references('id')->on('teachers');
      $table->unsignedBigInteger('student_id');
      $table->foreign('student_id')->references('id')->on('students');
      $table->timestamp('start_time')->nullable()->default(null);
      $table->timestamp('end_time')->nullable()->default(null);
      $table->time('duration')->nullable()->default(null);
      $table->enum('type', ['voice', 'video']);
      $table->enum('rating', ['like', 'dislike'])->nullable()->default(null);
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
    Schema::dropIfExists('calls');
  }
};
