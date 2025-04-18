<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class CryptHelper
{
    /**
     * データ暗号化
     */
    public static function encryptData(string $data): string
    {
        $appKey = base64_decode(str_replace('base64:', '', env('APP_KEY')));

        $iv = openssl_random_pseudo_bytes(16);
        $value = openssl_encrypt($data, 'aes-256-cbc', $appKey, OPENSSL_RAW_DATA, $iv);

        return base64_encode(json_encode([
            'iv' => base64_encode($iv),
            'value' => base64_encode($value),
        ]));
    }

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
