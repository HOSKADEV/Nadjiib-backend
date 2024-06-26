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
    Schema::create('post_likes', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('post_id');
      $table->foreign('post_id')->references('id')->on('posts');
      $table->unsignedBigInteger('student_id');
      $table->foreign('student_id')->references('id')->on('students');
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
    Schema::dropIfExists('post_likes');
  }
};
