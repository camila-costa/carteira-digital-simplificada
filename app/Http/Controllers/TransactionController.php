<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use App\Http\Requests\TransactionRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\WalletController;
use App\Enums\WalletOperation;

class TransactionController extends Controller
{
    /**
     * The transaction service implementation.
     *
     * @var TransactionService
     */
    protected $transactionService;

    /**
     * Create a new controller instance.
     *
     * @param  TransactionService  $transactionService
     * @return void
     */
    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Transaction::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\TransactionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TransactionRequest $request)
    {
        $params = $request->all();
        $newTransaction = null;

        DB::beginTransaction();
        try {
            // Update the user wallet
            $this->transactionService->updateUserWallet($params['payer'], $params['value'], WalletOperation::Subtraction);
            $this->transactionService->updateUserWallet($params['payee'], $params['value'], WalletOperation::Addition);

            $newTransaction = Transaction::create($params);
            DB::commit();
        } catch (Exception $ex) {
            Log::info($ex->getMessage());
            DB::rollBack();
            return response()->json($ex->getMessage(), 409);
        }

        return $newTransaction;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return $transaction;
    }
}
