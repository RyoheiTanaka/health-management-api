<?php

namespace App\Http\Controllers;

use App\Models\Innerscan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HealthPlanetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::asForm()->post('https://www.healthplanet.jp/status/innerscan.json', [
            'access_token' => env('HEALTHPLANET_ACCESS_TOKEN'),
            'date' => 1
        ]);

        $result = [];
        if (isset($response->json()['data'])) {
            $data = $response->json()['data'];
            $innerscans = collect($data)->sortBy('date')->groupBy('date')->map(function ($val) {
                return $val->pluck('keydata', 'tag');
            });

            foreach ($innerscans as $key => $innerscan) {
                $measurementDate = (new Carbon(strtotime($key)))->format('Y-m-d');
                $params = [
                    'body_weight' => floatval($innerscan['6021']),
                    'body_fat_percentage' => floatval($innerscan['6022']),
                    'measurement_date' => $measurementDate,
                ];
                Innerscan::updateOrCreate(['measurement_date' => $measurementDate], $params);
                $result[] = $params;
            }
        }

        return response()->json($result, 200);
    }
}
