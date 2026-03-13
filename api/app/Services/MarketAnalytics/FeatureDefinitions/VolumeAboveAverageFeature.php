<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * Volume Above Average Feature
 *
 * This feature checks whether the latest candle volume
 * is above its moving average volume by a given multiplier.
 *
 * It is commonly used to confirm strong participation
 * during breakouts or momentum moves.
 */
class VolumeAboveAverageFeature implements AnalyticFeatureInterface
{
    public function key(): string
    {
        return 'volume_above_average';
    }

    public function resolve(array $indicators, array $context = []): bool
    {
        $period = $context['period'] ?? 20;
        $multiplier = $context['multiplier'] ?? 1.0;

        $currentVolume = $context['volume'] ?? null;
        $volumeMaKey = "volume_ma_{$period}";
        $volumeMa = $indicators[$volumeMaKey] ?? null;

        if ($currentVolume === null || $volumeMa === null) {
            return false;
        }

        return $currentVolume > ($volumeMa * $multiplier);
    }
}
