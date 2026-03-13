<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * RSI Below Threshold Feature
 *
 * This feature checks if the Relative Strength Index (RSI)
 * is below a given threshold.
 */
class RsiBelowThresholdFeature implements AnalyticFeatureInterface
{
    public function key(): string
    {
        return 'rsi_below_threshold';
    }

    public function resolve(array $indicators, array $context = []): bool
    {
        $period = $context['period'] ?? 14;
        $threshold = $context['threshold'] ?? 50;
        $rsiKey = "rsi_{$period}";
        $rsiValue = $indicators[$rsiKey] ?? null;

        if ($rsiValue === null) {
            return false;
        }

        return $rsiValue < $threshold;
    }
}
