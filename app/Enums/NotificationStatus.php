<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class NotificationStatus extends Enum
{
    const Sent = 1;
    const Pending = 2;
}
