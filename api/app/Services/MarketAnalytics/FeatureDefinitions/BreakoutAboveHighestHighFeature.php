<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * Breakout Above Highest High Feature
 *
 * This feature detects if the current price breaks
 * above the highest high over a given lookback period.
 */
class BreakoutAboveHighestHighFeature implements AnalyticFeatureInterface
{
    public function key(): string
    {
        return 'breakout_above_highest_high';
    }

    public function resolve(array $indicators, array $context = []): bool
    {
        $period = $context['period'] ?? 20;
        $price = $context['price'] ?? null;
        $highestHighKey = "highest_high_{$period}";
        $highestHighValue = $indicators[$highestHighKey] ?? null;

        if ($price === null || $highestHighValue === null) {
            return false;
        }

        return $price > $highestHighValue;
    }
}
