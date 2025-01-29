<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FitbitWeightLog\IndexFitbitWeightLogFormRequest;
use App\Http\Requests\Api\FitbitWeightLog\ShowFitbitWeightLogFormRequest;
use App\Models\FitbitWeightLog;
use Carbon\Carbon;

class FitbitWeightLogController extends Controller
{
    /**
     * Handle the incoming index request.
     */
    public function index(IndexFitbitWeightLogFormRequest $request)
    {
        $isDashboard = $request->is_dashboard ?? false;

        $weightLogs = FitbitWeightLog::when($isDashboard, function ($query) {
            $date = (new Carbon())->subWeek()->format('Y-m-d');
            return $query->where('date', '>=', $date);
        })->orderBy('date')->get();

        return response([
            'data' => $weightLogs
        ]);
    }

    /**
     * Handle the incoming show request.
     */
    public function show(ShowFitbitWeightLogFormRequest $request, int $fitbitWeightLogId)
    {
        $weightLog = FitbitWeightLog::find($fitbitWeightLogId);

        return response([
            'data' => $weightLog
        ]);
    }
}
