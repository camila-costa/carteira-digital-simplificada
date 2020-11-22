<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
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
        $this->validate($request, [
            'value' => 'required|numeric',
        ]);

        $params = $request->all();

        // Keep the origin user_id
        $params['user_id'] = $wallet['user_id'];

        $wallet->update($params);
        return $wallet;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wallet  $wallet
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wallet $wallet)
    {
        //
    }
}
