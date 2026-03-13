<?php

namespace App\Services\MarketAnalytics\Indicators;

use App\Services\MarketAnalytics\Contracts\IndicatorInterface;

/**
 * Lowest Low
 *
 * This indicator returns the lowest low value over a given lookback period.
 * It is commonly used to identify support levels, consolidation ranges,
 * and potential breakdown points.
 */
class LowestLowIndicator implements IndicatorInterface
{
    public function key(): string
    {
        return 'lowest_low';
    }

    public function calculate(array $candles, array $params = []): float
    {
        $period = $params['period'] ?? 20;

        if (count($candles) < $period) {
            return 0;
        }

        $recentCandles = array_slice($candles, -$period);
        $lows = array_column($recentCandles, 'low');

        return min($lows);
    }
}
