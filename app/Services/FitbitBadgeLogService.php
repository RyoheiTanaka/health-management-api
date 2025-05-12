<?php

namespace App\Services;

use App\Repositories\FitbitBadgeLogRepositoryInterface;

class FitbitBadgeLogService
{
    public function __construct(protected FitbitBadgeLogRepositoryInterface $repository) {}

    public function getBadgeLogs(bool $isDashboard = false)
    {
        return $this->repository->getBadgeLogs($isDashboard);
    }

    public function getBadgeLog(int $badgeLogId)
    {
        return $this->repository->getBadgeLog($badgeLogId);
    }
}
