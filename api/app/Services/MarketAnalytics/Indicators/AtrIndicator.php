<?php

namespace App\Services\MarketAnalytics\Indicators;

use App\Services\MarketAnalytics\Contracts\IndicatorInterface;

/**
 * Average True Range (ATR)
 *
 * ATR is a volatility indicator that measures the average range of price movement
 * over a given number of periods. It does not indicate direction, only volatility.
 *
 * It is commonly used to estimate market noise, define dynamic stop-loss levels,
 * and evaluate whether a move is expanding or contracting.
 */
class AtrIndicator implements IndicatorInterface
{
    public function key(): string
    {
        return 'atr';
    }

    public function calculate(array $candles, array $params = []): float
    {
        $period = $params['period'] ?? 14;

        if (count($candles) <= $period) {
            return 0;
        }

        $trueRanges = [];

        for ($i = 1; $i < count($candles); $i++) {
            $currentHigh = $candles[$i]['high'];
            $currentLow = $candles[$i]['low'];
            $previousClose = $candles[$i - 1]['close'];

            $trueRange = max(
                $currentHigh - $currentLow,
                abs($currentHigh - $previousClose),
                abs($currentLow - $previousClose)
            );

            $trueRanges[] = $trueRange;
        }

        if (count($trueRanges) < $period) {
            return 0;
        }

        $recentTrueRanges = array_slice($trueRanges, -$period);

        return array_sum($recentTrueRanges) / $period;
    }
}
