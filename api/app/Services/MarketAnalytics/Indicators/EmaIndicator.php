<?php

namespace App\Services\MarketAnalytics\Indicators;

use App\Services\MarketAnalytics\Contracts\IndicatorInterface;

/**
 * Exponential Moving Average (EMA)
 *
 * The EMA is a type of moving average that gives more weight to recent prices,
 * making it more responsive to new market data than a Simple Moving Average (SMA).
 *
 * It is commonly used to identify trend direction and dynamic support/resistance.
 * The calculation starts with a Simple Moving Average (SMA) as the initial value,
 * then applies an exponential multiplier to smooth subsequent values.
 */
class EmaIndicator implements IndicatorInterface
{

    public function key(): string
    {
        return 'ema';
    }

    public function calculate(array $candles, array $params = []): float
    {
        // Determine the EMA period (default: 20)
        $period = $params['period'] ?? 20;

        // Extract closing prices from the candles array
        $prices = array_column($candles, 'close');

        // If there are not enough data points to compute the EMA, return 0
        if (count($prices) < $period) {
            return 0;
        }

        // EMA multiplier formula: 2 / (period + 1)
        $multiplier = 2 / ($period + 1);

        // Start by calculating the initial SMA (Simple Moving Average)
        // over the first "period" number of prices
        $ema = array_sum(array_slice($prices, 0, $period)) / $period;

        // Iterate over the remaining prices to calculate the EMA
        // EMA formula: (Price - Previous EMA) * Multiplier + Previous EMA
        foreach (array_slice($prices, $period) as $price) {
            $ema = ($price - $ema) * $multiplier + $ema;
        }

        // Return the final EMA value
        return $ema;
    }
}
