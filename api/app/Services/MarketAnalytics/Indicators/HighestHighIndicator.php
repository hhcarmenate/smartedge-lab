<?php

namespace App\Services\MarketAnalytics\Indicators;

use App\Services\MarketAnalytics\Contracts\IndicatorInterface;

/**
 * Highest High
 *
 * This indicator returns the highest high value over a given lookback period.
 * It is commonly used to detect breakout levels, resistance zones,
 * and consolidation ranges.
 */
class HighestHighIndicator implements IndicatorInterface
{
    public function key(): string
    {
        return 'highest_high';
    }

    public function calculate(array $candles, array $params = []): float
    {
        $period = $params['period'] ?? 20;

        if (count($candles) < $period) {
            return 0;
        }

        $recentCandles = array_slice($candles, -$period);
        $highs = array_column($recentCandles, 'high');

        return max($highs);
    }
}
