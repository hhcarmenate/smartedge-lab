<?php

namespace App\Services\MarketAnalytics;

use App\Services\MarketAnalytics\FeatureDefinitions\AtrAboveThresholdFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\AtrPctAboveThresholdFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\BollingerSqueezeFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\BreakdownBelowLowestLowFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\BreakoutAboveHighestHighFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\EmaBearishStackFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\EmaBullishStackFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\PriceAboveEmaFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\PriceBelowEmaFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\RsiAboveThresholdFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\RsiBelowThresholdFeature;
use App\Services\MarketAnalytics\FeatureDefinitions\VolumeAboveAverageFeature;

class FeatureRegistry
{
    public function features(): array
    {
        return [
            [
                'instance' => new PriceAboveEmaFeature(),
                'context' => ['period' => 20],
            ],
            [
                'instance' => new PriceAboveEmaFeature(),
                'context' => ['period' => 50],
            ],
            [
                'instance' => new PriceAboveEmaFeature(),
                'context' => ['period' => 100],
            ],
            [
                'instance' => new PriceAboveEmaFeature(),
                'context' => ['period' => 200],
            ],
            [
                'instance' => new EmaBullishStackFeature(),
                'context' => [],
            ],
            [
                'instance' => new RsiAboveThresholdFeature(),
                'context' => [
                    'period' => 14,
                    'threshold' => 50,
                ],
            ],
            [
                'instance' => new BollingerSqueezeFeature(),
                'context' => [
                    'period' => 20,
                    'width_threshold' => 10,
                ],
            ],
            [
                'instance' => new VolumeAboveAverageFeature(),
                'context' => [
                    'period' => 20,
                    'multiplier' => 1.2,
                ],
            ],
            [
                'instance' => new PriceBelowEmaFeature(),
                'context' => ['period' => 20],
            ],
            [
                'instance' => new PriceBelowEmaFeature(),
                'context' => ['period' => 50],
            ],
            [
                'instance' => new PriceBelowEmaFeature(),
                'context' => ['period' => 100],
            ],
            [
                'instance' => new PriceBelowEmaFeature(),
                'context' => ['period' => 200],
            ],
            [
                'instance' => new EmaBearishStackFeature(),
                'context' => [],
            ],
            [
                'instance' => new RsiBelowThresholdFeature(),
                'context' => [
                    'period' => 14,
                    'threshold' => 50,
                ],
            ],
            [
                'instance' => new BreakoutAboveHighestHighFeature(),
                'context' => [
                    'period' => 20,
                ],
            ],
            [
                'instance' => new BreakdownBelowLowestLowFeature(),
                'context' => [
                    'period' => 20,
                ],
            ],
            [
                'instance' => new AtrAboveThresholdFeature(),
                'context' => [
                    'period' => 14,
                    'threshold' => 2,
                ],
            ],
            [
                'instance' => new AtrPctAboveThresholdFeature(),
                'context' => [
                    'period' => 14,
                    'threshold' => 0.01,
                ],
            ],
        ];
    }
}
