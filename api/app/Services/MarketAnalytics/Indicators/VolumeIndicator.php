<?php

namespace App\Services\MarketAnalytics\Indicators;

use App\Services\MarketAnalytics\Contracts\IndicatorInterface;

/**
 * Represents a volume-based indicator that calculates the moving average
 * of volumes over a specified period.
 *
 * This class implements the IndicatorInterface and provides methods
 * to retrieve the key for the indicator and to perform the calculation
 * based on input data (candles) and parameters.
 */
class VolumeIndicator implements IndicatorInterface
{
    public function key(): string
    {
        return 'volume_ma';
    }

    public function calculate(array $candles, array $params = []): mixed
    {
        $period = $params['period'] ?? 20;

        if (count($candles) < $period) {
            return 0;
        }

        $volumes = array_column($candles, 'volume');
        $recentVolumes = array_slice($volumes, -$period);

        return array_sum($recentVolumes) / $period;
    }
}
