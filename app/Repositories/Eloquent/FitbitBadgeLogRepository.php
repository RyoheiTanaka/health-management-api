<?php

namespace App\Repositories\Eloquent;

use App\Models\FitbitBadgeLog;
use App\Repositories\FitbitBadgeLogRepositoryInterface;
use Illuminate\Support\Collection;

class FitbitBadgeLogRepository implements FitbitBadgeLogRepositoryInterface
{
    private $dashboardLimit = 5;

    public function getBadgeLogs(bool $isDashboard): Collection
    {
        return FitbitBadgeLog::when($isDashboard, function ($query) {
            return $query->limit($this->dashboardLimit);
        })->get();
    }

    public function getBadgeLog(int $badgeLogId): FitbitBadgeLog
    {
        return FitbitBadgeLog::findOrFail($badgeLogId);
    }
}
