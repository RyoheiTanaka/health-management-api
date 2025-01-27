<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 許可するIPアドレス
        $allowed_ips = [
            env('AWS_LAMBDA_EIP'),
        ];

        // リクエスト元IPが許可されていない場合
        if (!in_array($request->ip(), $allowed_ips)) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
