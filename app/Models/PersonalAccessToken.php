<?php

namespace App\Models;

use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;
use App\Helpers\CryptHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    /** @use HasFactory<\Database\Factories\PersonalAccessTokenFactory> */
    use HasFactory;

    /**
     * 暗号化されたアクセストークンを複合化してから取得
     *
     * @param  string  $token
     * @return static|null
     */
    public static function findToken($token)
    {
        $decryptToken = CryptHelper::decryptData($token);

        if (!$decryptToken) {
            return null;
        }

        if (strpos($decryptToken, '|') === false) {
            return static::where('token', hash('sha256', $decryptToken))->first();
        }

        [$id, $token] = explode('|', $decryptToken, 2);

        if ($instance = static::find($id)) {
            return hash_equals($instance->token, hash('sha256', $token)) ? $instance : null;
        }
    }
}
