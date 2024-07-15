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
        Schema::table('transactions', function (Blueprint $table) {
            //$table->dropConstrainedForeignId('student_id');
            $table->unsignedBigInteger('purchase_id')->after('id');
            $table->foreign('purchase_id')->references('id')->on('purchases');
            $table->string('account')->nullable()->default(null)->after('purchase_id');
            $table->string('receipt')->nullable()->default(null)->after('account');
            $table->json('data')->nullable()->default(null)->after('receipt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaction', function (Blueprint $table) {
            //
        });
    }
};
