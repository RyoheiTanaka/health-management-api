<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ScheduleRunController extends Controller
{
    public function index(Request $request)
    {
        Artisan::call('schedule:run');
        return response()->json(['message' => 'Schedule run executed successfully'], 200);
    }
}
