<?php

namespace App\Services\MarketAnalytics\Indicators;

use App\Services\MarketAnalytics\Contracts\IndicatorInterface;

/**
 * Relative Strength Index (RSI)
 *
 * RSI is a momentum oscillator that measures the speed and magnitude
 * of recent price movements. It ranges from 0 to 100 and is commonly
 * used to identify overbought and oversold conditions.
 *
 * Typical interpretation:
 * RSI > 70 → Overbought
 * RSI < 30 → Oversold
 */
class RsiIndicator implements IndicatorInterface
{
    public function key(): string
    {
        return 'rsi';
    }

    public function calculate(array $candles, array $params = []): float
    {
        $period = $params['period'] ?? 14;

        $prices = array_column($candles, 'close');

        if (count($prices) <= $period) {
            return 0;
        }

        $gains = 0;
        $losses = 0;

        for ($i = 1; $i <= $period; $i++) {
            $change = $prices[$i] - $prices[$i - 1];

            if ($change > 0) {
                $gains += $change;
            } else {
                $losses += abs($change);
            }
        }

        $avgGain = $gains / $period;
        $avgLoss = $losses / $period;

        if ($avgLoss == 0) {
            return 100;
        }

        $rs = $avgGain / $avgLoss;

        return 100 - (100 / (1 + $rs));
    }
}
