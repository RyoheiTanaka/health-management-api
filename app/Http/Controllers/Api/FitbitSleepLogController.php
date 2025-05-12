<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FitbitSleepLog\IndexFitbitSleepLogFormRequest;
use App\Http\Requests\Api\FitbitSleepLog\ShowFitbitSleepLogFormRequest;
use App\Http\Resources\FitbitSleepLogResource;
use App\Models\FitbitSleepLog;
use App\Services\FitbitSleepLogService;

class FitbitSleepLogController extends Controller
{
    public function __construct(protected FitbitSleepLogService $fitbitSleepLogService) {}
    /**
     * Handle the incoming index request.
     */
    public function index(IndexFitbitSleepLogFormRequest $request)
    {
        $isDashboard = $request->is_dashboard ?? false;

        $sleepLogs = $this->fitbitSleepLogService->getSleepLogs($isDashboard);

        return response([
            'data' => FitbitSleepLogResource::collection($sleepLogs)
        ]);
    }

    /**
     * Handle the incoming show request.
     */
    public function show(ShowFitbitSleepLogFormRequest $request, int $fitbitSleepLogId)
    {
        $sleepLog = $this->fitbitSleepLogService->getSleepLog($fitbitSleepLogId);

        return response([
            'data' => new FitbitSleepLogResource($sleepLog)
        ]);
    }
}
