<?php

namespace App\Services;

use App\Services\WalletService;

class TransactionService
{
    public function updateUserWallet(int $userId, float $value, int $operation)
    {
        $walletService = new WalletService();
        return $walletService->update($userId, $value, $operation);
    }

}
