<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\WalletOperation;

class Wallet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'value'];
    protected $dates = ['deleted_at'];

    public static function doOperation(float $currentValue, float $value, int $operation)
    {
        $newValue = 0;
        switch ($operation) {
            case WalletOperation::Addition:
                $newValue = $currentValue + $value;
                break;
            case WalletOperation::Subtraction:
                $newValue = $currentValue - $value;
                break;
            default:
                $newValue = $value;
                break;
        }
        return $newValue;
    }
}
