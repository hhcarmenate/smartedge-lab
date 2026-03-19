<?php

namespace App\Services\MarketAnalytics\Setups;

use App\Services\MarketAnalytics\Contracts\SetupInterface;

class BreakoutLongSetup implements SetupInterface
{
    public function key(): string
    {
        return 'breakout_long';
    }

    public function exists(array $features): bool
    {
        $trendOk =
            ($features['ema_bullish_stack'] ?? false) &&
            ($features['price_above_ema_50'] ?? false);

        $breakoutOk =
            ($features['breakout_above_highest_high_20'] ?? false);

        $expansionOk =
            ($features['atr_above_threshold_14'] ?? false);

        return $trendOk && $breakoutOk && $expansionOk;
    }

    public function score(array $features, array $indicators = []): float
    {
        $score = 0;

        // Trend quality
        if ($features['ema_bullish_stack'] ?? false) {
            $score += 10;
        }

        if ($features['price_above_ema_50'] ?? false) {
            $score += 10;
        }

        if ($features['price_above_ema_100'] ?? false) {
            $score += 10;
        }

        // Breakout quality
        if ($features['breakout_above_highest_high_20'] ?? false) {
            $score += 25;
        }

        if ($features['price_above_ema_20'] ?? false) {
            $score += 15;
        }

        // Expansion quality
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
