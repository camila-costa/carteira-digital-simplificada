<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $newUser = null;
        $params = $request->all();

        // Define user as UserType::ShopKeeper or UserType::Commom
        $params['user_type'] = User::documentToTypeUser($params['document']);

        DB::beginTransaction();
        try {
            $newUser = User::create($params);

            // Create the user wallet
            Wallet::create(
                [
                    'user_id' => $newUser['id'],
                    'value' => 0.00
                ]
            );

            DB::commit();
        } catch (Exception $ex) {
            Log::info($ex->getMessage());
            DB::rollBack();
            return response()->json($ex->getMessage(), 409);
        }

        return $newUser;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:200',
            'document' => 'required|cpf_cnpj',
            'email' => 'required|max:100',
            'password' => 'required|max:200'
        ]);

        $params = $request->all();
        // Define user as UserType::ShopKeeper or UserType::Commom
        $params['user_type'] = User::documentToTypeUser($params['document']);

        $user->update($params);
        return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();

            // Delete the user wallet
            $wallet = Wallet::where('user_id', $user['id'])->first();
            $wallet->delete();

            DB::commit();
        } catch (Exception $ex) {
            Log::info($ex->getMessage());
            DB::rollBack();
            return response()->json($ex->getMessage(), 409);
        }

        return response()->noContent();
    }
}
