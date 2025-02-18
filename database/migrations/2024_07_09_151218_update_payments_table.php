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
        Schema::table('payments', function (Blueprint $table) {
          // $table->dropColumn('type');
          // $table->dropColumn('is_paid');
          // $table->dropColumn('is_confirmed');
          $table->dropConstrainedForeignId('purchase_id');
          $table->unsignedBigInteger('teacher_id')->after('id');
          $table->foreign('teacher_id')->references('id')->on('teachers');
          $table->dateTime('date')->after('amount');
          $table->string('receipt')->nullable()->default(null)->after('payment_method');
          $table->enum('is_paid', ['yes', 'no'])->default('no')->after('date');
          $table->enum('is_confirmed', ['yes', 'no'])->default('no')->after('paid_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            //
        });
    }
};
