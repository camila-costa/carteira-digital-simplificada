<?php

namespace App\Services;

use App\Models\Notification;
use App\Enums\NotificationStatus;
use App\Traits\ExternalRequest;

class NotificationService
{
    use ExternalRequest;

    public function sendNotification(int $userId, int $transactionId)
    {
        $expectMessage = 'Enviado';
        $indexMessage = 'message';
        $url = 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04';

        $status = NotificationStatus::Pending;
        if($this->makeExternalRequest($url, $indexMessage, $expectMessage)) {
            $status = NotificationStatus::Sent;
        }

        $this->saveNotification($transactionId, $status);
    }

    private function saveNotification(int $transactionId, int $status)
    {
        $params = [
            'transaction_id' => $transactionId,
            'status' => $status
        ];
        Notification::create($params);
    }

}
