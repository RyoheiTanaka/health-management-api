<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FitbitSleepLog\IndexFitbitSleepLogFormRequest;
use App\Http\Requests\Api\FitbitSleepLog\ShowFitbitSleepLogFormRequest;
use App\Models\FitbitSleepLog;
use Carbon\Carbon;

class FitbitSleepLogController extends Controller
{
    /**
     * Handle the incoming index request.
     */
    public function index(IndexFitbitSleepLogFormRequest $request)
    {
        $isDashboard = $request->is_dashboard ?? false;

        $sleepLogs = FitbitSleepLog::when($isDashboard, function ($query) {
            $date = (new Carbon())->subWeek()->format('Y-m-d');
            return $query->where('date_of_sleep', '>=', $date);
        })->orderBy('date_of_sleep')->get();

        return response([
            'data' => $sleepLogs
        ]);
    }

    /**
     * Handle the incoming show request.
     */
    public function show(ShowFitbitSleepLogFormRequest $request, int $fitbitSleepLogId)
    {
        $sleepLog = FitbitSleepLog::find($fitbitSleepLogId);

        return response([
            'data' => $sleepLog
        ]);
    }
}
