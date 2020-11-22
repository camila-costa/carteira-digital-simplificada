<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['user_id', 'value'];
    protected $dates = ['deleted_at'];

    public static function doOperation(float $currentValue, float $value)
    {
        return $currentValue + $value;
    }
}
