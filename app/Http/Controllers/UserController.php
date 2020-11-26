<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * The transaction service implementation.
     *
     * @var UserService
     */
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @param  UserService  $userService
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

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
        $params['user_type'] = User::documentToUserType($params['document']);

        DB::beginTransaction();
        try {
            $newUser = User::create($params);

            // Create the user wallet
            $this->userService->createUserWallet($newUser['id']);

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
        $params['user_type'] = User::documentToUserType($params['document']);

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
            $this->userService->deleteUserWallet($user['id']);

            DB::commit();
        } catch (Exception $ex) {
            Log::info($ex->getMessage());
            DB::rollBack();
            return response()->json($ex->getMessage(), 409);
        }

        return response()->noContent();
    }
}
