<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * EMA Bearish Stack Feature
 *
 * This feature checks whether EMAs are aligned
 * in bearish order:
 *
 * EMA 20 < EMA 50 < EMA 100 < EMA 200
 *
 * It is commonly used to confirm strong bearish trend structure.
 */
class EmaBearishStackFeature implements AnalyticFeatureInterface
{
    public function key(): string
    {
        return 'ema_bearish_stack';
    }

    public function resolve(array $indicators, array $context = []): bool
    {
        $ema20 = $indicators['ema_20'] ?? null;
        $ema50 = $indicators['ema_50'] ?? null;
        $ema100 = $indicators['ema_100'] ?? null;
        $ema200 = $indicators['ema_200'] ?? null;

        if (
            $ema20 === null ||
            $ema50 === null ||
            $ema100 === null ||
            $ema200 === null
        ) {
            return false;
        }

        return $ema20 < $ema50
            && $ema50 < $ema100
            && $ema100 < $ema200;
    }
}
