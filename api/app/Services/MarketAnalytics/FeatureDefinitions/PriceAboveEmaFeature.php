<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * Price Above EMA Feature
 *
 * This feature evaluates whether the latest closing price
 * is above a specific EMA value.
 *
 * It is commonly used to confirm bullish structure
 * and trend alignment.
 */
class PriceAboveEmaFeature implements AnalyticFeatureInterface
{
    public function key(): string
    {
        return 'price_above_ema';
    }

    public function resolve(array $indicators, array $context = []): bool
    {
        $period = $context['period'] ?? 20;

        $price = $context['price'] ?? null;
        $emaKey = "ema_{$period}";
        $emaValue = $indicators[$emaKey] ?? null;

        if ($price === null || $emaValue === null) {
            return false;
        }

        return $price > $emaValue;
    }
}
