<?php

namespace App\Http\Controllers\Dashboard\Wallet;

use App\Repositories\Wallet\WalletRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
    protected WalletRepository $walletRepository;

    public function __construct(WalletRepository $walletRepository)
    {
        $this->walletRepository = $walletRepository;
    }

    /**
     * Display a paginated list of wallet transactions.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $search = $request->input('search');
        $status = $request->input('status');

        $transactions = $this->walletRepository->paginate($perPage, $search, $status);
        return view('dashboard.wallet.index', compact('transactions'));
    }

    /**
     * Store a newly created wallet transaction.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount'  => 'required|numeric',
            'type'    => 'required|string',
            'status'  => 'required|string'
        ]);

        $transaction = $this->walletRepository->create($data);
        return response()->json($transaction, 201);
    }

    /**
     * Display the specified wallet transaction.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $transaction = $this->walletRepository->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        return response()->json($transaction);
    }

    /**
     * Update the specified wallet transaction.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed                    $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $transaction = $this->walletRepository->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $data = $request->validate([
            'user_id' => 'sometimes|exists:users,id',
            'amount'  => 'sometimes|numeric',
            'type'    => 'sometimes|string',
            'status'  => 'sometimes|string'
        ]);

        $updated = $this->walletRepository->update($id, $data);
        return response()->json($updated);
    }

    /**
     * Remove the specified wallet transaction.
     *
     * @param  mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $transaction = $this->walletRepository->find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $this->walletRepository->delete($id);
        return response()->json(['message' => 'Transaction deleted successfully']);
    }

    /**
     * Change the status of the specified wallet transaction.
     *
     * @param mixed $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeStatus($id)
    {
        $transaction = $this->walletRepository->changeStatus($id);
        return response()->json($transaction);
    }

    /**
     * Display deposit transactions for a given user.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function userTransactions(Request $request, int $user_id)
    {
        $perPage = $request->input('per_page', 15);
        $search  = $request->input('search');
        $status  = $request->input('status');
        $type    = $request->input('type'); // Optional filter

        $transactions = $this->walletRepository->getDepositTransactions($user_id, $perPage, $search, $status, $type);
        return response()->json($transactions);
    }
}
