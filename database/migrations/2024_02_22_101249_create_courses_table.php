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
    Schema::create('courses', function (Blueprint $table) {
      $table->id();
      $table->unsignedBigInteger('teacher_id');
      $table->foreign('teacher_id')->references('id')->on('teachers');
      $table->unsignedBigInteger('subject_id');
      $table->foreign('subject_id')->references('id')->on('subjects');
      $table->string('name');
      $table->longText('description');
      $table->double('price')->default(0.0);
      $table->string('image')->nullable()->default(null);
      $table->string('video')->nullable()->default(null);
      $table->enum('status',['PENDING','ACCEPTED','REFUSED'])->default('PENDING');
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
    Schema::dropIfExists('courses');
  }
};
