<?php

namespace App\Services;

use App\Repositories\FitbitFatLogRepositoryInterface;

class FitbitFatLogService
{
    public function __construct(protected FitbitFatLogRepositoryInterface $repository) {}

    public function getFatLogs(bool $isDashboard = false)
    {
        return $this->repository->getFatLogs($isDashboard);
    }

    public function getFatLog(int $fatLogId)
    {
        return $this->repository->getFatLog($fatLogId);
    }
}
