<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Services\WalletService;
use App\Enums\WalletOperation;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    /**
     * The transaction service implementation.
     *
     * @var WalletService
     */
    protected $walletService;

    /**
     * Create a new controller instance.
     *
     * @param  WalletService  $walletService
     * @return void
     */
    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Wallet::all();
    }

    /**
     * Display a listing of the resource from userId.
     *
     * @param  int  $userId
     * @return \Illuminate\Http\Response
     */
    public function indexFromUser(int $userId)
    {
        return Wallet::where('user_id', $userId)->first();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function show(Wallet $wallet)
    {
        return $wallet;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wallet $wallet)
    {
        if ($request->method() == 'PATCH') {
            try {
                $this->validate($request, [
                    'value' => 'required|numeric',
                ]);

                $params = $request->all();
                $value = $params['value'];
                // Keep the origin user_id
                $userId = $wallet['user_id'];

                $wallet = $this->walletService->update($userId, $value, WalletOperation::Addition);
                DB::commit();
                return $wallet;
            } catch (Exception $ex) {
                Log::info($ex->getMessage());
                DB::rollBack();
                return response()->json($ex->getMessage(), 409);
            }
        }

        // If is PUT, sends 405
        return response()->json([
            'message' => 'Method Not Allowed',
        ], 405);
    }
}
