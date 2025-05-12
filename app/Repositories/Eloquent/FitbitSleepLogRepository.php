<?php

namespace App\Repositories\Eloquent;

use App\Models\FitbitSleepLog;
use App\Repositories\FitbitSleepLogRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FitbitSleepLogRepository implements FitbitSleepLogRepositoryInterface
{
    public function getSleepLogs(bool $isDashboard): Collection
    {
        return FitbitSleepLog::when($isDashboard, function ($query) {
            $date = (new Carbon())->subWeek()->format('Y-m-d');
            return $query->where('date_of_sleep', '>=', $date);
        })->orderBy('date_of_sleep')->get();
    }

    public function getSleepLog(int $sleepLogId): FitbitSleepLog
    {
        return FitbitSleepLog::findOrFail($sleepLogId);
    }
}
