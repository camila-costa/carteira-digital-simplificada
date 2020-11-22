<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\UserType;

class User extends Model
{
    use HasFactory;
    use SoftDeletes;

    const MAX_CPF = 14;

    protected $fillable = ['name', 'user_type', 'document', 'email', 'password'];
    protected $dates = ['deleted_at'];

    public static function documentToUserType(string $document)
    {
        return (strlen($document) > User::MAX_CPF) ? UserType::ShopKeeper : UserType::Commom;
    }
}
