<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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

        if (empty($encryptedCustomHeader)) {
            return response()->json(['error' => 'Forbidden CheckLambdaCustomHeader'], 403);
        }

        try {
            // カスタムヘッダーの複合
            $decryptedCustomHeader = decrypt(base64_decode($encryptedCustomHeader));

            // カスタムヘッダーの値を検証
            if ($decryptedCustomHeader !== env('AWS_LAMBDA_REQUEST_HEADER')) {
                return response()->json(['error' => 'Forbidden CheckLambdaCustomHeader'], 403);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Forbidden CheckLambdaCustomHeader'], 403);
        }

        return $next($request);
    }
}
