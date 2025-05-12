<?php

namespace App\Repositories;

use App\Models\FitbitBadgeLog;
use Illuminate\Support\Collection;

interface FitbitBadgeLogRepositoryInterface
{
    public function getBadgeLogs(bool $isDashboard): Collection;
    public function getBadgeLog(int $badgeLogId): FitbitBadgeLog;
}
