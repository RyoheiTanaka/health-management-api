<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FitbitBadgeLog\IndexFitbitBadgeLogFormRequest;
use App\Http\Requests\Api\FitbitBadgeLog\ShowFitbitBadgeLogFormRequest;
use App\Models\FitbitBadgeLog;

class FitbitBadgeLogController extends Controller
{
    /**
     * Handle the incoming index request.
     */
    public function index(IndexFitbitBadgeLogFormRequest $request)
    {
        $isDashboard = $request->is_dashboard ?? false;

        $badgeLogs = FitbitBadgeLog::when($isDashboard, function ($query) {
            return $query->limit(5);
        })->get();

        return response([
            'data' => $badgeLogs
        ]);
    }

    /**
     * Handle the incoming show request.
     */
    public function show(ShowFitbitBadgeLogFormRequest $request, int $fitbitBadgeLogId)
    {
        $badgeLog = FitbitBadgeLog::find($fitbitBadgeLogId);

        return response([
            'data' => $badgeLog
        ]);
    }
}
