<?php

namespace App\Repositories;

use App\Models\FitbitFatLog;
use Illuminate\Support\Collection;

interface FitbitFatLogRepositoryInterface
{
    public function getFatLogs(bool $isDashboard): Collection;
    public function getFatLog(int $fatLogId): FitbitFatLog;
}
