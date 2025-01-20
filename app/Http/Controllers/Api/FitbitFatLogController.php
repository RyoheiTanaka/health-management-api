<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\FitbitFatLog\ShowFitbitFatLogFormRequest;
use App\Models\FitbitFatLog;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FitbitFatLogController extends Controller
{
    /**
     * Handle the incoming index request.
     */
    public function index(Request $request)
    {
        $date = (new Carbon())->subWeek()->format('Y-m-d');
        $fatLogs = FitbitFatLog::where('date', '>=', $date)->orderBy('date')->get();

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
