<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * ATR Percentage Above Threshold Feature
 *
 * This feature checks if the ATR as a percentage
 * of current price is above a given threshold.
 */
class AtrPctAboveThresholdFeature implements AnalyticFeatureInterface
{
    public function key(): string
    {
        return 'atr_pct_above_threshold';
    }

    public function resolve(array $indicators, array $context = []): bool
    {
        $period = $context['period'] ?? 14;
        $price = $context['price'] ?? null;
        $threshold = $context['threshold'] ?? 0.01;
        $atrKey = "atr_{$period}";
        $atrValue = $indicators[$atrKey] ?? null;

        if ($atrValue === null || $price === null || $price <= 0) {
            return false;
        }

        $atrPct = $atrValue / $price;

        return $atrPct > $threshold;
    }
}
