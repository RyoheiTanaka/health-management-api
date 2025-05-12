<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FitbitBadgeLog\IndexFitbitBadgeLogFormRequest;
use App\Http\Requests\Api\FitbitBadgeLog\ShowFitbitBadgeLogFormRequest;
use App\Http\Resources\FitbitBadgeLogResource;
use App\Services\FitbitBadgeLogService;

class FitbitBadgeLogController extends Controller
{
    public function __construct(protected FitbitBadgeLogService $fitbitBadgeLogService) {}

    /**
     * Handle the incoming index request.
     */
    public function index(IndexFitbitBadgeLogFormRequest $request)
    {
        $isDashboard = $request->is_dashboard ?? false;

        $badgeLogs = $this->fitbitBadgeLogService->getBadgeLogs($isDashboard);

        return response([
            'data' => FitbitBadgeLogResource::collection($badgeLogs)
        ]);
    }

    /**
     * Handle the incoming show request.
     */
    public function show(ShowFitbitBadgeLogFormRequest $request, int $fitbitBadgeLogId)
    {
        $badgeLog = $this->fitbitBadgeLogService->getBadgeLog($fitbitBadgeLogId);

        return response([
            'data' => new FitbitBadgeLogResource($badgeLog)
        ]);
    }
}
