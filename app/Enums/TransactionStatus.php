<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class TransactionStatus extends Enum
{
    const Authorized = 1;
    const Cancelled = 2;
}
