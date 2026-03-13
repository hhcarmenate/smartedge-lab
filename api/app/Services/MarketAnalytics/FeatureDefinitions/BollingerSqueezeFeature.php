<?php

namespace App\Services\MarketAnalytics\FeatureDefinitions;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

/**
 * Bollinger Squeeze Feature
 *
 * This feature checks whether Bollinger Band width is below
 * a given threshold, which may indicate volatility compression.
 *
 * It is commonly used to identify potential breakout setups.
 */
class BollingerSqueezeFeature implements AnalyticFeatureInterface
{
    public function key(): string
    {
        return 'bollinger_squeeze';
    }

    public function resolve(array $indicators, array $context = []): bool
    {
        $period = $context['period'] ?? 20;
        $widthThreshold = $context['width_threshold'] ?? 10;

        $bbKey = "bollinger_bands_{$period}";
        $bollingerBands = $indicators[$bbKey] ?? null;

        if (! is_array($bollingerBands)) {
            return false;
        }

        $width = $bollingerBands['width'] ?? null;

        if ($width === null) {
            return false;
        }

        return $width < $widthThreshold;
    }
}
