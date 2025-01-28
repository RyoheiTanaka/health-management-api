<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FitbitFatLog\IndexFitbitFatLogFormRequest;
use App\Http\Requests\Api\FitbitFatLog\ShowFitbitFatLogFormRequest;
use App\Models\FitbitFatLog;
use Carbon\Carbon;

class FitbitFatLogController extends Controller
{
    /**
     * Handle the incoming index request.
     */
    public function index(IndexFitbitFatLogFormRequest $request)
    {
        $isDashboard = $request->is_dashboard ?? false;

        $fatLogs = FitbitFatLog::when($isDashboard, function ($query) {
            $date = (new Carbon())->subWeek()->format('Y-m-d');
            return $query->where('date', '>=', $date);
        })->orderBy('date')->get();

        return response([
            'data' => $fatLogs
        ]);
    }

    /**
     * Handle the incoming show request.
     */
    public function show(ShowFitbitFatLogFormRequest $request, int $fitbitFatLogId)
    {
        $fatLog = FitbitFatLog::find($fitbitFatLogId);

        return response([
            'data' => $fatLog
        ]);
    }
}
