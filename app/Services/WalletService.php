<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\WalletLog;
use App\Enums\WalletOperation;

class WalletService
{
    public function update(int $userId, float $value, int $operation)
    {
        $wallet = Wallet::where('user_id', '=', $userId)->firstOrFail();

        // Do an operation with the current and the new value
        $newValue = Wallet::doOperation($wallet->value, $value, $operation);

        $wallet->update(['user_id' => $userId, 'value' => $newValue]);

        // If operation is WalletOperation::Subtraction, put the value negative to save in the log
        if($operation == WalletOperation::Subtraction) {
            $value = -$value;
        }
        $this->saveWalletLog($wallet->id, $value);

        return $wallet;
    }

    public function saveWalletLog(int $walletId, float $value)
    {
        WalletLog::create(
            [
                'wallet_id' => $walletId,
                'value' => $value
            ]
        );
    }
}
