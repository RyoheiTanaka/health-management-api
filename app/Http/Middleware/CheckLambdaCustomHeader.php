<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CheckLambdaCustomHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // カスタムヘッダーを取得
        $encryptedCustomHeader = $request->header('X-Lamdba-Request-Header');
        echo ($encryptedCustomHeader);
        if (empty($encryptedCustomHeader)) {
            return response()->json(['error' => 'Forbidden CheckLambdaCustomHeader'], 403);
        }

        try {
            // カスタムヘッダーの複合
            $decryptedCustomHeader = $this->decryptData($encryptedCustomHeader);

            // カスタムヘッダーの値を検証
            if ($decryptedCustomHeader !== env('AWS_LAMBDA_REQUEST_HEADER')) {
                return response()->json(['error' => 'Forbidden CheckLambdaCustomHeader'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Forbidden CheckLambdaCustomHeader'], 403);
        }

        return $next($request);
    }


    private function getAesKey(): string
    {
        $appKey = env('APP_KEY');

        if (Str::startsWith($appKey, 'base64:')) {
            return substr(base64_decode(substr($appKey, 7)), 0, 32);
        }

        return substr($appKey, 0, 32);
    }

    private function decryptData(string $encrypted): string
    {
        try {
            $key = $this->getAesKey();
            $data = base64_decode($encrypted);

            $iv = substr($data, 0, 16);
            $ciphertext = substr($data, 16);

            $decrypted = openssl_decrypt($ciphertext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

            return $decrypted ?: 'Decryption failed';
        } catch (Exception $e) {
            Log::error('Decryption error: ' . $e->getMessage());
            return 'Decryption error';
        }
    }
}
