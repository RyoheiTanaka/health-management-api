<?php

namespace App\Console\Commands;

use App\Models\FitbitBadgeLog;
use App\Models\FitbitFatLog;
use App\Models\FitbitSleepLog;
use App\Models\FitbitToken;
use App\Models\FitbitWeightLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ImportFitbitData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-fitbit-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fitbitに登録されているデータをDBに登録する';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Fitbitデータインポート開始');

        $url = env('FITBIT_API_URL');
        $accessToken = $this->getAccessToken();

        $date = Carbon::yesterday()->format('Y-m-d');

        // 体重関連データ
        if (FitbitWeightLog::where('date', $date)->doesntExist()) {
            try {
                $response = Http::withToken($accessToken)
                    ->withHeaders(['accept-language' => 'ja_JP'])
                    ->get("{$url}/1/user/-/body/log/weight/date/{$date}.json");

                $weights = $response->json()['weight'];

                if (!empty($weights)) {
                    foreach ($weights as $weight) {
                        FitbitWeightLog::updateOrCreate(['date' => $weight['date']], [
                            'weight' => $weight['weight'],
                            'bmi' => $weight['bmi'],
                            'date' => $weight['date'],
                        ]);
                    }
                } else {
                    Log::info('体重データが取得できませんでした。', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'heder' => $response->headers(),
                    ]);
                }
            } catch (Exception $e) {
                Log::error('体重データインポートに失敗しました。', [
                    'date' => $date,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        // 体脂肪関連データ
        if (FitbitFatLog::where('date', $date)->doesntExist()) {
            try {
                $response = Http::withToken($accessToken)
                    ->withHeaders(['accept-language' => 'ja_JP'])
                    ->get("{$url}/1/user/-/body/log/fat/date/{$date}.json");

                $fats = $response->json()['fat'];

                if (!empty($fats)) {
                    foreach ($fats as $fat) {
                        FitbitFatLog::updateOrCreate(['date' => $fat['date']], [
                            'fat' => $fat['fat'],
                            'date' => $fat['date'],
                        ]);
                    }
                } else {
                    Log::info('体脂肪データが取得できませんでした。', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'heder' => $response->headers(),
                    ]);
                }
            } catch (Exception $e) {
                Log::error('体脂肪データインポートに失敗しました。', [
                    'date' => $date,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        // 睡眠関連データ
        if (FitbitSleepLog::where('date_of_sleep', $date)->doesntExist()) {
            try {
                $response = Http::withToken($accessToken)
                    ->withHeaders(['accept-language' => 'ja_JP'])
                    ->get("{$url}/1.2/user/-/sleep/date/{$date}.json");

                $sleeps = $response->json()['sleep'];

                if (!empty($sleeps)) {
                    foreach ($sleeps as $sleep) {
                        FitbitSleepLog::updateOrCreate(['date_of_sleep' => $sleep['dateOfSleep']], [
                            'duration' => $sleep['duration'],
                            'efficiency' => $sleep['efficiency'],
                            'info_code' => $sleep['infoCode'],
                            'date_of_sleep' => $sleep['dateOfSleep'],
                            'end_time' => $sleep['endTime'],
                        ]);
                    }
                } else {
                    Log::info('睡眠データが取得できませんでした。', [
                        'status' => $response->status(),
                        'body' => $response->body(),
                        'heder' => $response->headers(),
                    ]);
                }
            } catch (Exception $e) {
                Log::error('睡眠データインポートに失敗しました。', [
                    'date' => $date,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        // バッチ関連データ
        try {
            $response = Http::withToken($accessToken)
                ->withHeaders(['accept-language' => 'ja_JP'])
                ->get("{$url}/1/user/-/badges.json");

            $badges = $response->json()['badges'];

            if (!empty($badges)) {
                foreach ($badges as $badge) {
                    FitbitBadgeLog::updateOrCreate(['name' => $badge['name']], [
                        'category' => $badge['category'],
                        'badge_type' => $badge['badgeType'],
                        'name' => $badge['name'],
                        'short_name' => $badge['shortName'],
                        'description' => $badge['description'],
                        'image300px' => $badge['image300px'],
                        'image125px' => $badge['image125px'],
                        'date_time' => $badge['dateTime'],
                        'times_achieved' => $badge['timesAchieved'],
                    ]);
                }
            } else {
                Log::info('バッチデータが取得できませんでした。', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'heder' => $response->headers(),
                ]);
            }
        } catch (Exception $e) {
            Log::error('バッチデータインポートに失敗しました。', [
                'date' => $date,
                'message' => $e->getMessage(),
            ]);
        }

        Log::info('Fitbitデータインポート終了');
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
