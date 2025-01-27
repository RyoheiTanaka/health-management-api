<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $allowedIps = [
            env('AWS_LAMBDA_EIP'),
        ];

        Log::info($request->header('x-real-ip'));
        Log::info(!in_array($request->header('x-real-ip'), $allowedIps));
        // リクエスト元IPが許可されていない場合
        if (!in_array($request->header('x-real-ip'), $allowedIps)) {
            return response()->json(['error' => 'Forbidden CheckIP'], 403);
        }

        return $next($request);
    }
}
