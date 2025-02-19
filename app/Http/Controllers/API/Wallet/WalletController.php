<?php

namespace App\Http\Controllers\API\Wallet;

use App\Enums\WalletTransactionStatus;
use App\Http\Controllers\Controller;
use App\Http\Traits\uploadFile;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;


class WalletController extends Controller
{
  use uploadFile;
  public function deposit(Request $request)
  {
    $data = Validator::make($request->all(), [
      'amount' => 'required|numeric|min:1',
      'payment_method' => 'required|in:baridimob,poste,chargily',
      'account' => 'required_if:payment_method,baridimob',
      'receipt' => 'required_if:payment_method,baridimob|required_if:payment_method,poste',
      'checkout_id' => 'required_if:payment_method,chargily|string|unique:transactions'
    ]);

    if ($data->fails()) {
      return response()->json([
        'status' => false,
        'message' => $data->errors()->first(),
      ], 422);
    }
    try {
      $user = Auth::user();
      DB::beginTransaction();
      $path = null;
      if ($request->hasFile('receipt')) {
        $path = $this->SaveDocument($request->receipt, 'documents/purchase/receipt/');
        $path = $path->getPathName();
      }

      newTransaction($user->id, $request->amount, $request->payment_method, "Deposit", $request->checkout_id, $path, $request->account);

      DB::commit();

      return response()->json([
        'status' => true,
        'message' => 'success'
      ]);
    } catch (Exception $e) {
      DB::rollback();
      return response()->json([
        'status' => false,
        'message' => $e->getMessage()
      ]);
    }
  }

  public function getTransactions()
  {
    $user = Auth::user();
    $transactions = WalletTransaction::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
    return response()->json([
      'status' => true,
      'data' => $transactions
    ]);
  }

  public function chargily(Request $request)
  {
    try {
      if (empty($request->checkout_id)) {
        throw new Exception('no checkout id');
      }
      $credentials = new \Chargily\ChargilyPay\Auth\Credentials(json_decode(file_get_contents(base_path('chargily-pay-env.json')), true));
      $chargily_pay = new \Chargily\ChargilyPay\ChargilyPay($credentials);
      $checkout = $chargily_pay->checkouts()->get($request->checkout_id);

      if (empty($checkout)) {
        throw new Exception('invalid checkout id');
      }
      $transaction = WalletTransaction::where('checkout_id', $checkout->getId())->first();
      if (empty($transaction)) {
        throw new Exception('no transaction found');
      }
      if ($transaction->status != 'pending') {
        throw new Exception('deposit already settled');
      }
      $diff_customer = $transaction->user->customer_id != $checkout->getCustomerId();

      if ($diff_customer) {
        throw new Exception('conflicted informations');
      }

      if ($request->routeIs('chargily-failed')) {
        cancelTransaction($transaction->id);
        return redirect()->route('purchase-failed');

      } else {
        DB::beginTransaction();
        validateTransaction($transaction->id);
        DB::commit();
        return redirect()->route('purchase-success');

      }
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
      return redirect()->route('error');
    }
  }
}
