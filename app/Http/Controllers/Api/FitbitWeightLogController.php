<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FitbitWeightLog\IndexFitbitWeightLogFormRequest;
use App\Http\Requests\Api\FitbitWeightLog\ShowFitbitWeightLogFormRequest;
use App\Http\Resources\FitbitWeightLogResource;
use App\Services\FitbitWeightLogService;

class FitbitWeightLogController extends Controller
{
    public function __construct(protected FitbitWeightLogService $fitbitWeightLogService) {}

    /**
     * Handle the incoming index request.
     */
    public function index(IndexFitbitWeightLogFormRequest $request)
    {
        $isDashboard = $request->is_dashboard ?? false;

        $weightLogs = $this->fitbitWeightLogService->getweightLogs($isDashboard);

        return response([
            'data' => FitbitWeightLogResource::collection($weightLogs)
        ]);
    }

    /**
     * Handle the incoming show request.
     */
    public function show(ShowFitbitWeightLogFormRequest $request, int $fitbitWeightLogId)
    {
        $weightLog = $this->fitbitWeightLogService->getweightLog($fitbitWeightLogId);

        return response([
            'data' => new FitbitWeightLogResource($weightLog)
        ]);
    }
}
