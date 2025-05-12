<?php

namespace App\Repositories;

use App\Models\FitbitSleepLog;
use Illuminate\Support\Collection;

interface FitbitSleepLogRepositoryInterface
{
    public function getSleepLogs(bool $isDashboard): Collection;
    public function getSleepLog(int $sleepLogId): FitbitSleepLog;
}
