<?php

namespace App\Services;

use App\Models\Wallet;

class WalletService
{
    public function update(int $userId, float $value, int $operation)
    {
        $wallet = Wallet::where('user_id', '=', $userId)->firstOrFail();

        // Do an operation with the current and the new value
        $value = Wallet::doOperation($wallet->value, $value, $operation);

        $wallet->update(['user_id' => $userId, 'value' => $value]);
        return $wallet;
    }

}
