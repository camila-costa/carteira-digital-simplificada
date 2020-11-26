<?php

namespace App\Services;

use App\Services\WalletService;
use App\Services\NotificationService;
use App\Enums\TransactionStatus;
use App\Traits\ExternalRequest;

class TransactionService
{
    use ExternalRequest;

    public function updateUserWallet(int $userId, float $value, int $operation)
    {
        $walletService = new WalletService();
        return $walletService->update($userId, $value, $operation);
    }

    public function authorizeTransaction()
    {
        $expectMessage = 'Autorizado';
        $indexMessage = 'message';
        $url = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

        if($this->makeExternalRequest($url, $indexMessage, $expectMessage)) {
            return TransactionStatus::Authorized;
        }

        return TransactionStatus::Cancelled;
    }

    public function notifyPayee(int $userId, int $transactionId)
    {
        $notificationService = new NotificationService();
        $notificationService->sendNotification($userId, $transactionId);
    }

}
