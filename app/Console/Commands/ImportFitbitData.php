<?php

namespace App\Console\Commands;

use App\Services\FitbitLogService;
use App\Models\FitbitBadgeLog;
use App\Models\FitbitFatLog;
use App\Models\FitbitSleepLog;
use App\Models\FitbitWeightLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;
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
     * Create a new instance.
     */
    public function __construct(private FitbitLogService $fitbitLogService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Log::info('Fitbitデータインポート開始');

        $date = Carbon::yesterday()->format('Y-m-d');

        // 体重関連データ
        if (FitbitWeightLog::where('date', $date)->doesntExist()) {
            try {
                $weightLogs = $this->fitbitLogService->getFitbitWeightLog($date);

                if (!empty($weightLogs['weights'])) {
                    foreach ($weightLogs['weights'] as $weight) {
                        FitbitWeightLog::updateOrCreate(['date' => $weight['date']], [
                            'weight' => $weight['weight'],
                            'bmi' => $weight['bmi'],
                            'date' => $weight['date'],
                        ]);
                    }
                } else {
                    Log::info('体重データが取得できませんでした。', [
                        'status' => $weightLogs['status'],
                        'header' => $weightLogs['header'],
                        'body' => $weightLogs['body'],
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
                $fatLogs = $this->fitbitLogService->getFitbitFatLog($date);

                if (!empty($fatLogs['fats'])) {
                    foreach ($fatLogs['fats'] as $fat) {
                        FitbitFatLog::updateOrCreate(['date' => $fat['date']], [
                            'fat' => $fat['fat'],
                            'date' => $fat['date'],
                        ]);
                    }
                } else {
                    Log::info('体脂肪データが取得できませんでした。', [
                        'status' => $fatLogs['status'],
                        'header' => $fatLogs['header'],
                        'body' => $fatLogs['body'],
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
                $sleepLogs = $this->fitbitLogService->getFitbitSleepLog($date);

                if (!empty($sleepLogs['sleeps'])) {
                    foreach ($sleepLogs['sleeps'] as $sleep) {
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
                        'status' => $sleepLogs['status'],
                        'header' => $sleepLogs['header'],
                        'body' => $sleepLogs['body'],
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
            $badgeLogs = $this->fitbitLogService->getFitbitBadgeLog($date);

            if (!empty($badgeLogs['badges'])) {
                foreach ($badgeLogs['badges'] as $badge) {
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
                    'status' => $weightLogs['status'],
                    'header' => $weightLogs['header'],
                    'body' => $weightLogs['body'],
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
}
