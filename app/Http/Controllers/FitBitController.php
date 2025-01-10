<?php

namespace App\Http\Controllers;

use App\Models\FitbitToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class FitBitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $url = env('FITBIT_API_URL');
        $accessToken = $this->getAccessToken();
        $date = Carbon::now()->format('Y-m-d');

        $result = Http::withToken($accessToken)
            ->get("{$url}/1/user/-/body/log/weight/date/{$date}.json");

        return response()->json($result->json(), 200);
    }

    private function getAccessToken()
    {
        $fitbitToken = FitbitToken::first();

        if ($fitbitToken->expiration_datetime < Carbon::now()->format('Y-m-d H:i:s')) {
            $response = Http::asForm()
                ->post('https://api.fitbit.com/oauth2/token', [
                    'grant_type' => 'refresh_token',
                    'client_id' => env('FITBIT_CLIENT_ID'),
                    'refresh_token' => Crypt::decrypt($fitbitToken->refresh_token),
                ]);

            $result = $response->json();

            $fitbitToken->delete();
            $fitbitToken = FitbitToken::create([
                'access_token' => Crypt::encrypt($result['access_token']),
                'refresh_token' => Crypt::encrypt($result['refresh_token']),
                'expiration_datetime' => Carbon::now()->addSeconds($result['expires_in'])->format('Y-m-d H:i:s'),
            ]);
        }

        if (!empty($fitbitToken) && !is_null($fitbitToken->access_token)) {
            return Crypt::decrypt($fitbitToken->access_token);
        }

        return env('FITBIT_ACCESS_TOKEN');
    }
}
