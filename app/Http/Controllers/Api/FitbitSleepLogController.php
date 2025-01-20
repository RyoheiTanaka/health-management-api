<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FitbitSleepLog\ShowFitbitSleepLogFormRequest;
use App\Models\FitbitSleepLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FitbitSleepLogController extends Controller
{
    /**
     * Handle the incoming index request.
     */
    public function index(Request $request)
    {
        $date = (new Carbon())->subWeek()->format('Y-m-d');
        $sleepLogs = FitbitSleepLog::where('date_of_sleep', '>=', $date)->orderBy('date_of_sleep')->get();

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
