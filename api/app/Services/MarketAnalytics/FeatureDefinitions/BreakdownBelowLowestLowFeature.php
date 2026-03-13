<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * Breakdown Below Lowest Low Feature
 *
 * This feature detects if the current price breaks
 * below the lowest low over a given lookback period.
 */
class BreakdownBelowLowestLowFeature implements AnalyticFeatureInterface
{
    public function key(): string
    {
        return 'breakdown_below_lowest_low';
    }

    public function resolve(array $indicators, array $context = []): bool
    {
        $period = $context['period'] ?? 20;
        $price = $context['price'] ?? null;
        $lowestLowKey = "lowest_low_{$period}";
        $lowestLowValue = $indicators[$lowestLowKey] ?? null;

        if ($price === null || $lowestLowValue === null) {
            return false;
        }

        return $price < $lowestLowValue;
    }
}
