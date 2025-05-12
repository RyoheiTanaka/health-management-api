<?php

namespace App\Repositories\Eloquent;

use App\Models\FitbitWeightLog;
use App\Repositories\FitbitWeightLogRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FitbitWeightLogRepository implements FitbitWeightLogRepositoryInterface
{
    private $dashboardLimit = 5;

    public function getWeightLogs(bool $isDashboard): Collection
    {
        return FitbitWeightLog::when($isDashboard, function ($query) {
            $date = (new Carbon())->subWeek()->format('Y-m-d');
            return $query->where('date', '>=', $date);
        })->orderBy('date')->get();
    }

    public function getWeightLog(int $weightLogId): FitbitWeightLog
    {
        return FitbitWeightLog::findOrFail($weightLogId);
    }
}
