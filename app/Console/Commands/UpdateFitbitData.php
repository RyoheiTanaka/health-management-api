<?php

namespace App\Console\Commands;

use App\Models\FitbitToken;
use App\Models\Innerscan;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UpdateFitbitData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-fitbit-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'DBの体重、体脂肪データをFitbitに登録する';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Fitbitデータ登録開始');

        $url = config('services.fitbit.api_url');
        $accessToken = $this->getAccessToken();

        $innerScanData = Innerscan::where('is_data_linkage', 0)->get();

        foreach ($innerScanData as $innerScan) {
            try {
                $isWeightSuccess = true;
                $isFatSuccess = true;

                if (!empty($innerScan->body_weight)) {
                    $weightResult = Http::withToken($accessToken)
                        ->asForm()
                        ->post("{$url}/1/user/-/body/log/weight.json", [
                            'weight' => $innerScan->body_weight,
                            'date' => $innerScan->measurement_date
                        ]);

                    $isWeightSuccess = $weightResult->successful();
                }

                if (!empty($innerScan->body_fat_percentage)) {
                    $fatResult = Http::withToken($accessToken)
                        ->asForm()
                        ->post("{$url}/1/user/-/body/log/fat.json", [
                            'fat' => $innerScan->body_fat_percentage,
                            'date' => $innerScan->measurement_date
                        ]);

                    $isFatSuccess = $fatResult->successful();
                }

                if ($isWeightSuccess && $isFatSuccess) {
                    $innerScan->update(['is_data_linkage' => 1]);
                } else {
                    if (!empty($weightResult)) {
                        Log::info('weightResult', [
                            'status' => $weightResult->status(),
                            'body' => $weightResult->body(),
                            'heder' => $weightResult->headers(),
                        ]);
                    }

                    if (!empty($fatResult)) {
                        Log::info('fatResult', [
                            'status' => $fatResult->status(),
                            'body' => $fatResult->body(),
                            'heder' => $fatResult->headers(),
                        ]);
                    }

                    throw new Exception('Fitbitのステータスが201ではありませんでした。');
                }
            } catch (Exception $e) {
                Log::error('登録に失敗しました。', [
                    'id' => $innerScan->id,
                    'message' => $e->getMessage(),
                ]);
                continue;
            }
        }

        Log::info('Fitbitデータ登録終了');
    }

    private function getAccessToken()
    {
        $fitbitToken = FitbitToken::first();

        if ($fitbitToken->expiration_datetime < Carbon::now()->format('Y-m-d H:i:s')) {
            $clientId = config('services.fitbit.client_id');
            $clientSecret = config('services.fitbit.client_secret');

            $authorizationHeader = base64_encode("{$clientId}:{$clientSecret}");

            $response = Http::asForm()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $authorizationHeader
                ])
                ->post('https://api.fitbit.com/oauth2/token', [
                    'grant_type' => 'refresh_token',
                    'client_id' => $clientId,
                    'refresh_token' => Crypt::decrypt($fitbitToken->refresh_token),
                ]);

            $result = $response->json();

            if (!$result['success']) {
                Log::error('トークンリフレッシュに失敗しました。', [
                    'errorType' => $result['errors'][0]['errorType'],
                    'message' => $result['errors'][0]['message'],
                ]);
                exit;
            }

            DB::transaction(function ($fitbitToken, $result) {
                $fitbitToken->delete();
                $fitbitToken = FitbitToken::create([
                    'access_token' => Crypt::encrypt($result['access_token']),
                    'refresh_token' => Crypt::encrypt($result['refresh_token']),
                    'expiration_datetime' => Carbon::now()->addSeconds($result['expires_in'])->format('Y-m-d H:i:s'),
                ]);
            });
        }

        if (!empty($fitbitToken) && !is_null($fitbitToken->access_token)) {
            return Crypt::decrypt($fitbitToken->access_token);
        }

        return config('services.fitbit.access_token');
    }
}
