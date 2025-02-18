<?php

use App\Enums\PaymentMethod;
use App\Enums\WalletAction;
use App\Enums\WalletTransactionStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('account')->nullable();
            $table->string('receipt')->nullable();
            $table->string('checkout_id')->nullable();
            $table->enum('status', WalletTransactionStatus::lists2())->default('pending');
            $table->enum('type',WalletAction::lists2());
            $table->string('description')->nullable();
            $table->enum('payment_method', PaymentMethod::lists2());
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
