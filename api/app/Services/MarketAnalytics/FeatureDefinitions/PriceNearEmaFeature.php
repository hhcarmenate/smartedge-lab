<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * Price Near EMA Feature
 *
 * Evaluates whether the current price is near a given EMA,
 * using ATR-based dynamic tolerance.
 */
class PriceNearEmaFeature implements AnalyticFeatureInterface
{

    public function key(): string
    {
        return 'price_near_ema';
    }

    public function resolve(array $indicators, array $context = []): mixed
    {
        $period = $context['period'] ?? 20;
        $price = $context['price'] ?? null;
        $multiplier = $context['tolerance_atr_multiplier'] ?? 0.5;

        $emaKey = "ema_{$period}";
        $emaValue = $indicators[$emaKey] ?? null;
        $atr = $indicators['atr_14'] ?? null;

        if ($price === null || $emaValue === null || $atr === null) {
            return false;
        }

        $tolerance = $atr * $multiplier;

        return abs($price - $emaValue) <= $tolerance;
    }
}
