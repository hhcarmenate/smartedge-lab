<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * ATR Above Threshold Feature
 *
 * This feature checks if the Average True Range (ATR)
 * is above an absolute threshold.
 */
class AtrAboveThresholdFeature implements AnalyticFeatureInterface
{
    public function key(): string
    {
        return 'atr_above_threshold';
    }

    public function resolve(array $indicators, array $context = []): bool
    {
        $period = $context['period'] ?? 14;
        $threshold = $context['threshold'] ?? 2;
        $atrKey = "atr_{$period}";
        $atrValue = $indicators[$atrKey] ?? null;

        if ($atrValue === null) {
            return false;
        }

        return $atrValue > $threshold;
    }
}
