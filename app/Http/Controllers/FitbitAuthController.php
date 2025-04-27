<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FitbitAuthController extends Controller
{
    public function __invoke(Request $request)
    {
        $clientId = config('services.fitbit.client_id');

        // PKCEコード生成
        $codeVerifier = Str::random(64);
        $codeChallenge = rtrim(strtr(base64_encode(hash('sha256', $codeVerifier, true)), '+/', '-_'), '=');

        session([
            'fitbit_code_verifier' => $codeVerifier,
        ]);

        $authorizeUrl = "https://www.fitbit.com/oauth2/authorize?" . http_build_query([
            'response_type' => 'code',
            'client_id' => $clientId,
            'scope' => 'profile activity sleep',
            'code_challenge' => $codeChallenge,
            'code_challenge_method' => 'S256',
        ]);

        return redirect()->away($authorizeUrl);
    }
}
