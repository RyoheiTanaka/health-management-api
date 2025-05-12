<?php

namespace App\Repositories;

use App\Models\FitbitWeightLog;
use Illuminate\Support\Collection;

interface FitbitWeightLogRepositoryInterface
{
    public function getWeightLogs(bool $isDashboard): Collection;
    public function getWeightLog(int $weightLogId): FitbitWeightLog;
}
