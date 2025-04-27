<?php

namespace App\Http\Controllers;

use App\Models\FitbitToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class FitbitCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return response()->json(['error' => 'Authorization code not found'], 400);
        }

        $clientId = config('services.fitbit.client_id');
        $clientSecret = config('services.fitbit.client_secret');
        $redirectUri = config('services.fitbit.redirect_uri');

        $codeVerifier = session('fitbit_code_verifier');

        if (!$codeVerifier) {
            return response()->json(['error' => 'Code verifier not found'], 400);
        }

        // トークンリクエスト
        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post('https://api.fitbit.com/oauth2/token', [
                'grant_type' => 'authorization_code',
                'client_id' => $clientId,
                'redirect_uri' => $redirectUri,
                'code' => $code,
                'code_verifier' => $codeVerifier,
            ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'Token request failed', 'details' => $response->json()], 400);
        }

        $tokenData = $response->json();

        // 取得したトークンを保存
        FitbitToken::latest()->first()->delete();
        FitbitToken::create([
            'access_token' => Crypt::encrypt($tokenData['access_token']),
            'refresh_token' => Crypt::encrypt($tokenData['refresh_token']),
            'expiration_datetime' => Carbon::now()->addSeconds($tokenData['expires_in'])->format('Y-m-d H:i:s'),
        ]);

        // セッションから使い終わったcode_verifierを削除
        session()->forget('fitbit_code_verifier');

        // フロントにリダイレクト（成功パラメータ付き）
        return redirect(config('app.frontend_url') . '/settings?fitbit=connected');
    }
}
