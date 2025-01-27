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
        $allowedHeader = env('AWS_LAMBDA_REQUEST_HEADER');

        // カスタムヘッダーの値を検証
        if ($request->header('X-Lamdba-Request-Header') !== $allowedHeader) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
