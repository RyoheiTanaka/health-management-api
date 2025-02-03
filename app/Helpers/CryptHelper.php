<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class CryptHelper
{
    /**
     * データ復号化
     */
    public static function decryptData(string $encryptedBase64): string
    {
        // Base64 でエンコードされたデータをデコード
        $encryptedData = json_decode(base64_decode($encryptedBase64), true);

        // IV と暗号化されたデータを取り出す
        $iv = base64_decode($encryptedData['iv']);
        $value = base64_decode($encryptedData['value']);

        $appKey = base64_decode(str_replace('base64:', '', env('APP_KEY')));

        $decrypted = openssl_decrypt(
            $value,
            'aes-256-cbc',
            $appKey,
            OPENSSL_RAW_DATA,
            $iv
        );

        return $decrypted;
    }
}
