<?php

use App\Enums\WalletAction;
use App\Enums\WalletTransactionStatus;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Database\Eloquent\Collection;


function newTransaction(int $user_id,float $amount,string $paymentMehode,string|null $description = null,int $checkoutId= null, string|null $receipt = null,string|null $account = null): void
{
  $wallet = Wallet::where('user_id', $user_id)->first();
  if (!$wallet) {
   $wallet = findOrCreateWallet($user_id, $amount);
  }

  createWalletTransaction($user_id, $amount, WalletAction::DEPOSIT, WalletTransactionStatus::PENDING,$paymentMehode, $checkoutId, $receipt, $account, $description);
}


function validateTransaction(int $transaction_id): void
{
  $transaction = WalletTransaction::find($transaction_id);
  if ($transaction) {
    $transaction->update([
      'status' => WalletTransactionStatus::SUCCESS
    ]);
    $wallet = Wallet::where('user_id', $transaction->user_id)->first();
    $wallet->update([
      'balance' => $wallet->balance + $transaction->amount
    ]);
  }
}

function cancelTransaction(int $transaction_id): void
{
  $transaction = WalletTransaction::find($transaction_id);
  if ($transaction) {
    $transaction->update([
      'status' => WalletTransactionStatus::FAILED
    ]);
  }
}

function takeFromWallet(int $user_id,float  $amount,string  $type,string  $paymentMehode,string|null $description = null): int
{
  $wallet = findOrCreateWallet($user_id);
  if ($wallet->balance < $amount) {
      return -1;
  }
  $wallet->update([
    'balance' => $wallet->balance - $amount
  ]);

  createWalletTransaction($user_id, $amount, $type, WalletTransactionStatus::SUCCESS, $paymentMehode,null, null, null, $description);

  return 1;
}



function getWalletBalance(int $user_id): float
{
  $wallet = findOrCreateWallet($user_id);
  return $wallet->balance;
}

function findOrCreateWallet(int $user_id, float $amount = 0):Wallet
{
  $wallet = Wallet::where('user_id', $user_id)->first();
  if(!$wallet){
    $wallet = Wallet::create([
      'user_id' => $user_id,
      'balance' => $amount
    ]);
  }
  return $wallet;
}


function createWalletTransaction(int $user_id, float $amount, string $type, string $status,string $paymentMehode, string|null $checkoutId = null, string|null $receipt = null,string|null $account = null,string|null $description = null):WalletTransaction
{
  $walletTransaction =WalletTransaction::create([
    'user_id' => $user_id,
    'amount' => $amount,
    'type' => $type,
    "status" => $status,
    'checkout_id' => $checkoutId,
    'receipt' => $receipt,
    'account' => $account,
    'description' => $description,
    'payment_method' => $paymentMehode
  ]);
  return $walletTransaction;
}


