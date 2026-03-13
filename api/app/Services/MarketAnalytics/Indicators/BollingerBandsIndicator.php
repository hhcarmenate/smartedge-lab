<?php

namespace App\Services\MarketAnalytics\Indicators;

use App\Services\MarketAnalytics\Contracts\IndicatorInterface;

/**
 * Bollinger Bands
 *
 * Bollinger Bands measure price volatility around a moving average.
 * They consist of:
 * - a middle band (usually a 20-period SMA)
 * - an upper band
 * - a lower band
 *
 * The upper and lower bands are calculated using standard deviations.
 * They are commonly used to detect volatility expansion, contraction,
 * overextension, and possible mean reversion zones.
 */
class BollingerBandsIndicator implements IndicatorInterface
{
    public function key(): string
    {
        return 'bollinger_bands';
    }

    public function calculate(array $candles, array $params = []): array
    {
        $period = $params['period'] ?? 20;
        $stdDevMultiplier = $params['std_dev'] ?? 2;

        $prices = array_column($candles, 'close');

        if (count($prices) < $period) {
            return [
                'middle' => 0,
                'upper' => 0,
                'lower' => 0,
                'width' => 0,
            ];
        }

        $recentPrices = array_slice($prices, -$period);

        $sma = array_sum($recentPrices) / $period;

        $variance = array_sum(
                array_map(
                    fn ($price) => pow($price - $sma, 2),
                    $recentPrices
                )
            ) / $period;

        $standardDeviation = sqrt($variance);

        $upperBand = $sma + ($standardDeviation * $stdDevMultiplier);
        $lowerBand = $sma - ($standardDeviation * $stdDevMultiplier);

        $width = $upperBand - $lowerBand;

        return [
            'middle' => $sma,
            'upper' => $upperBand,
            'lower' => $lowerBand,
            'width' => $width,
        ];
    }
}
