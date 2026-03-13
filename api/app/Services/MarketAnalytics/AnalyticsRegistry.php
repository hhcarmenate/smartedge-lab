<?php

namespace App\Services\MarketAnalytics;

use App\Services\MarketAnalytics\Indicators\AtrIndicator;
use App\Services\MarketAnalytics\Indicators\BollingerBandsIndicator;
use App\Services\MarketAnalytics\Indicators\EmaIndicator;
use App\Services\MarketAnalytics\Indicators\HighestHighIndicator;
use App\Services\MarketAnalytics\Indicators\RsiIndicator;
use App\Services\MarketAnalytics\Indicators\VolumeIndicator;

class AnalyticsRegistry
{
    public function indicators(): array
    {
        return [
            [
                'instance' => new EmaIndicator(),
                'params' => ['period' => 20],
            ],
            [
                'instance' => new EmaIndicator(),
                'params' => ['period' => 50],
            ],
            [
                'instance' => new EmaIndicator(),
                'params' => ['period' => 100],
            ],
            [
                'instance' => new EmaIndicator(),
                'params' => ['period' => 200],
            ],
            [
                'instance' => new RsiIndicator(),
                'params' => ['period' => 14],
            ],
            [
                'instance' => new AtrIndicator(),
                'params' => ['period' => 14],
            ],
            [
                'instance' => new BollingerBandsIndicator(),
                'params' => ['period' => 20, 'std_dev' => 2],
            ],
            [
                'instance' => new VolumeIndicator(),
                'params' => ['period' => 20],
            ],
            [
                'instance' => new HighestHighIndicator(),
                'params' => ['period' => 20],
            ]
        ];
    }
}
