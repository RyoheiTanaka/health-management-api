<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\FitbitToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class FitbitController extends Controller
{
    public function redirectToFitbit()
    {
        $clientId = config('services.fitbit.client_id');
        $redirectUri = urlencode(config('services.fitbit.redirect_uri'));
        $scope = 'activity profile profile sleep weight';
        $fitbitAuthUrl = "https://www.fitbit.com/oauth2/authorize?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}&scope={$scope}";

        return redirect()->away($fitbitAuthUrl);
    }

    public function handleFitbitCallback(Request $request)
    {
        $code = $request->query('code');

        if (!$code) {
            return response()->json(['error' => 'Authorization code missing'], 400);
        }

        $clientId = config('services.fitbit.client_id');
        $clientSecret = config('services.fitbit.client_secret');
        $redirectUri = config('services.fitbit.redirect_uri');

        $response = Http::withBasicAuth($clientId, $clientSecret)
            ->asForm()
            ->post('https://api.fitbit.com/oauth2/token', [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => $redirectUri,
            ]);

        $tokenData = $response->json();

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to get access token', 'details' => $tokenData], 400);
        }

        // 取得したトークンを保存（DB または セッション）
        FitbitToken::latest()->first()->delete();
        FitbitToken::create([
            'access_token' => Crypt::encrypt($tokenData['access_token']),
            'refresh_token' => Crypt::encrypt($tokenData['refresh_token']),
            'expiration_datetime' => Carbon::now()->addSeconds($tokenData['expires_in'])->format('Y-m-d H:i:s'),
        ]);

        return redirect('/')->with('success', 'Fitbit認証成功');
    }
}
