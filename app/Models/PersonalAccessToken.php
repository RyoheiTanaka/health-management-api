<?php

namespace App\Models;

use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    /**
     * 暗号化されたアクセストークンを複合化してから取得
     *
     * @param  string  $token
     * @return static|null
     */
    public static function findToken($token)
    {
        echo 'testtse';
        return 'testtset';
    }
}
