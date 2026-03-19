<?php

namespace App\Services\MarketAnalytics\Setups;

use App\Services\MarketAnalytics\Contracts\SetupInterface;

class TrendPullbackLongSetup implements SetupInterface
{
    public function key(): string
    {
        return 'trend_pullback_long';
    }

    public function exists(array $features): bool
    {
        // Trend
        $trendOk =
            ($features['ema_bullish_stack'] ?? false) &&
            ($features['price_above_ema_50'] ?? false);

        // Pullback
        $pullbackOk =
            ($features['price_near_ema_20'] ?? false) ||
            ($features['price_near_ema_50'] ?? false);

        // Structure intact
        $structureOk =
            !($features['price_below_ema_100'] ?? false);

        return $trendOk && $pullbackOk && $structureOk;
    }

    public function score(array $features, array $indicators = []): float
    {
        $score = 0;

        // Trend (40)
        if ($features['ema_bullish_stack'] ?? false) {
            $score += 15;
        }

        if ($features['price_above_ema_50'] ?? false) {
            $score += 10;
        }

        if ($features['price_above_ema_100'] ?? false) {
            $score += 10;
        }

        if ($features['price_above_ema_200'] ?? false) {
            $score += 5;
        }

        // Pullback (30)
        if ($features['price_near_ema_20'] ?? false) {
            $score += 15;
        }

        if ($features['price_near_ema_50'] ?? false) {
            $score += 15;
        }

        // Continuation (30)
        if ($features['rsi_above_threshold_14'] ?? false) {
            $score += 10;
        }

        if ($features['volume_above_average_20'] ?? false) {
            $score += 10;
        }

        if ($features['atr_above_threshold_14'] ?? false) {
            $score += 10;
        }

        return $score;
    }
}
