<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FitbitFatLog\IndexFitbitFatLogFormRequest;
use App\Http\Requests\Api\FitbitFatLog\ShowFitbitFatLogFormRequest;
use App\Http\Resources\FitbitFatLogResource;
use App\Models\FitbitFatLog;
use App\Services\FitbitFatLogService;
use Carbon\Carbon;

class FitbitFatLogController extends Controller
{
    public function __construct(protected FitbitFatLogService $fitbitFatLogService) {}

    /**
     * Handle the incoming index request.
     */
    public function index(IndexFitbitFatLogFormRequest $request)
    {
        $isDashboard = $request->is_dashboard ?? false;

        $fatLogs = $this->fitbitFatLogService->getFatLogs($isDashboard);

        return response([
            'data' => FitbitFatLogResource::collection($fatLogs)
        ]);
    }

    /**
     * Handle the incoming show request.
     */
    public function show(ShowFitbitFatLogFormRequest $request, int $fitbitFatLogId)
    {
        $fatLog = $this->fitbitFatLogService->getFatLog($fitbitFatLogId);

        return response([
            'data' => new FitbitFatLogResource($fatLog)
        ]);
    }
}
