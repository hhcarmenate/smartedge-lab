<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * RSI Above Threshold Feature
 *
 * This feature checks whether RSI is above a given threshold.
 *
 * It is commonly used to confirm bullish momentum
 * or to validate trend continuation conditions.
 */
class RsiAboveThresholdFeature implements AnalyticFeatureInterface
{
    public function key(): string
    {
        return 'rsi_above_threshold';
    }

    public function resolve(array $indicators, array $context = []): bool
    {
        $threshold = $context['threshold'] ?? 50;
        $period = $context['period'] ?? 14;

        $rsiKey = "rsi_{$period}";
        $rsiValue = $indicators[$rsiKey] ?? null;

        if ($rsiValue === null) {
            return false;
        }

        return $rsiValue > $threshold;
    }
}
