<?php

namespace App\Services\MarketAnalytics;

use App\Services\MarketAnalytics\Setups\BollingerSqueezeLongSetup;
use App\Services\MarketAnalytics\Setups\BreakoutLongSetup;
use App\Services\MarketAnalytics\Setups\TrendPullbackLongSetup;

class SetupRegistry
{
    public function setups(): array
    {
        return [
            new TrendPullbackLongSetup(),
            new BreakoutLongSetup(),
            new BollingerSqueezeLongSetup(),
        ];
    }
}
