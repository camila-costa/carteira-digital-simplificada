<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\Transaction;

class TransactionTest extends TestCase
{
    public function testFillable()
    {
        $fillable = ['value', 'payer', 'payee', 'status'];
        $transaction = new Transaction();
        $this->assertEquals($fillable, $transaction->getFillable());
    }
}
