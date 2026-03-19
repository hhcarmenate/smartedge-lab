<?php

namespace App\Services\MarketAnalytics\Setups;

use App\Services\MarketAnalytics\Contracts\SetupInterface;

class BollingerSqueezeLongSetup implements SetupInterface
{
    public function key(): string
    {
        return 'bollinger_squeeze_long';
    }

    public function exists(array $features): bool
    {
        $trendOk =
            ($features['ema_bullish_stack'] ?? false) &&
            ($features['price_above_ema_50'] ?? false);

        $squeezeOk =
            ($features['bollinger_squeeze_20'] ?? false);

        $expansionPotentialOk =
            ($features['atr_pct_above_threshold_14'] ?? false);

        return $trendOk && $squeezeOk && $expansionPotentialOk;
    }

    public function score(array $features, array $indicators = []): float
    {
        $score = 0;

        // Trend quality (30)
        if ($features['ema_bullish_stack'] ?? false) {
            $score += 10;
        }

        if ($features['price_above_ema_50'] ?? false) {
            $score += 10;
        }

        if ($features['price_above_ema_100'] ?? false) {
            $score += 10;
        }

        // Squeeze quality (40)
        if ($features['bollinger_squeeze_20'] ?? false) {
            $score += 25;
        }

        if ($features['price_above_ema_20'] ?? false) {
            $score += 15;
        }

        // Expansion readiness (30)
        if ($features['volume_above_average_20'] ?? false) {
            $score += 10;
        }

        if ($features['atr_above_threshold_14'] ?? false) {
            $score += 10;
        }

        if ($features['rsi_above_threshold_14'] ?? false) {
            $score += 10;
        }

        return $score;
    }
}
