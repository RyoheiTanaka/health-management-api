<?php

namespace App\Services;

use App\Repositories\FitbitWeightLogRepositoryInterface;

class FitbitWeightLogService
{
    public function __construct(protected FitbitWeightLogRepositoryInterface $repository) {}

    public function getWeightLogs(bool $isDashboard = false)
    {
        return $this->repository->getWeightLogs($isDashboard);
    }

    public function getWeightLog(int $weightLogId)
    {
        return $this->repository->getWeightLog($weightLogId);
    }
}
