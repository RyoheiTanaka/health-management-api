<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DecryptApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // `Authorization` ヘッダーを取得
        $authorizationHeader = $request->header('Authorization');

        if ($authorizationHeader && str_starts_with($authorizationHeader, 'Bearer ')) {
            try {
                // `Bearer ` を除去
                $encryptedToken = substr($authorizationHeader, 7);

                // トークンを復号
                $decryptedToken = decrypt(base64_decode($encryptedToken));

                // リクエストの `Authorization` ヘッダーを復号済みのトークンに置き換える
                $request->headers->set('Authorization', 'Bearer ' . $decryptedToken);
            } catch (\Exception $e) {
                return response()->json(['error' => 'Invalid token'], 401);
            }
        }

        return $next($request);
    }
}
