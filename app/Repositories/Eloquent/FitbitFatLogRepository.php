<?php

namespace App\Repositories\Eloquent;

use App\Models\FitbitFatLog;
use App\Repositories\FitbitFatLogRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FitbitFatLogRepository implements FitbitFatLogRepositoryInterface
{
    private $dashboardLimit = 5;

    public function getFatLogs(bool $isDashboard): Collection
    {
        return FitbitFatLog::when($isDashboard, function ($query) {
            $date = (new Carbon())->subWeek()->format('Y-m-d');
            return $query->where('date', '>=', $date);
        })->orderBy('date')->get();
    }

    public function getFatLog(int $FatLogId): FitbitFatLog
    {
        return FitbitFatLog::findOrFail($FatLogId);
    }
}
