<?php

namespace App\Services;

use App\Models\Wallet;
use App\Services\WalletService;

class UserService
{
    public function createUserWallet(int $userId)
    {
        $value = 0.00;
        Wallet::create(
            [
                'user_id' => $userId,
                'value' => $value
            ]
        );

        $walletService = new WalletService();
        $walletService->saveWalletLog($userId, $value);
    }

    public function deleteUserWallet(int $userId)
    {
        $wallet = Wallet::where('user_id', $userId)->first();
        $wallet->delete();
    }
}
