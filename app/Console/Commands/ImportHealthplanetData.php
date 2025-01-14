<?php

namespace App\Console\Commands;

use App\Models\Innerscan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportHealthplanetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-healthplanet-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Health Planetに登録されているデータをDBに登録する';

    /**
     * Execute the console command.
     */
    public function handle()
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
    }
}
