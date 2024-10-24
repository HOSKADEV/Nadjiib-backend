<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id');
            $table->foreign('ad_id')->references('id')->on('ads');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses');
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
        Schema::dropIfExists('course_ads');
    }
};
