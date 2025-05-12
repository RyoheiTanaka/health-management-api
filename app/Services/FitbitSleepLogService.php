<?php

namespace App\Services;

use App\Repositories\FitbitSleepLogRepositoryInterface;

class FitbitSleepLogService
{
    public function __construct(protected FitbitSleepLogRepositoryInterface $repository) {}

    public function getSleepLogs(bool $isDashboard = false)
    {
        return $this->repository->getSleepLogs($isDashboard);
    }

    public function getSleepLog(int $sleepLogId)
    {
        return $this->repository->getSleepLog($sleepLogId);
    }
}
