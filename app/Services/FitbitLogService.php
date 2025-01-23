<?php

namespace App\Services;

use App\Models\FitbitToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class FitbitLogService
{
    private ?string $fitbitApiUrl;
    private string $defaultDate;

    public function __construct()
    {
        $this->fitbitApiUrl = env('FITBIT_API_URL');
        $this->defaultDate = Carbon::now()->format('Y-m-d');
    }

    public function getAccessToken(): string
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

    /**
     * Fitbitの体重ログを取得
     */
    public function getFitbitWeightLog(?string $date = null): mixed
    {
        $accessToken = $this->getAccessToken();
        $excuteDate = $date ?? $this->defaultDate;

        $response = Http::withToken($accessToken)
            ->withHeaders(['accept-locale' => 'ja_JP'])
            ->get("{$this->fitbitApiUrl}/1/user/-/body/log/weight/date/{$excuteDate}.json");

        return  [
            'status' => $response->status(),
            'header' => $response->headers(),
            'body' => $response->body(),
            'weights' => $response->json()['weight'],
        ];
    }

    /**
     * Fitbitの体脂肪ログを取得
     */
    public function getFitbitFatLog(?string $date = null): mixed
    {
        $accessToken = $this->getAccessToken();
        $excuteDate = $date ?? $this->defaultDate;

        $response = Http::withToken($accessToken)
            ->withHeaders(['accept-locale' => 'ja_JP'])
            ->get("{$this->fitbitApiUrl}/1/user/-/body/log/fat/date/{$excuteDate}.json");

        return  [
            'status' => $response->status(),
            'header' => $response->headers(),
            'body' => $response->body(),
            'fats' => $response->json()['fat'],
        ];
    }

    /**
     * Fitbitの睡眠ログを取得
     */
    public function getFitbitSleepLog(?string $date = null): mixed
    {
        $accessToken = $this->getAccessToken();
        $excuteDate = $date ?? $this->defaultDate;

        $response = Http::withToken($accessToken)
            ->withHeaders(['accept-locale' => 'ja_JP'])
            ->get("{$this->fitbitApiUrl}/1.2/user/-/sleep/date/{$excuteDate}.json");

        return  [
            'status' => $response->status(),
            'header' => $response->headers(),
            'body' => $response->body(),
            'sleeps' => $response->json()['sleep'],
        ];
    }

    /**
     * Fitbitのバッチを取得
     */
    public function getFitbitBadgeLog(): mixed
    {
        $accessToken = $this->getAccessToken();

        $response = Http::withToken($accessToken)
            ->withHeaders(['accept-locale' => 'ja_JP'])
            ->get("{$this->fitbitApiUrl}/1/user/-/badges.json");

        return  [
            'status' => $response->status(),
            'header' => $response->headers(),
            'body' => $response->body(),
            'badges' => $response->json()['badges'],
        ];
    }
}
