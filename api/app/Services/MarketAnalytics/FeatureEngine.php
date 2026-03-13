<?php

namespace App\Services\MarketAnalytics;

use App\Services\MarketAnalytics\Contracts\AnalyticFeatureInterface;

class FeatureEngine
{
    protected array $features = [];

    public function __construct(FeatureRegistry $featureRegistry)
    {
        foreach ($featureRegistry->features() as $featureConfig) {
            $this->register(
                $featureConfig['instance'],
                $featureConfig['context'] ?? []
            );
        }
    }

    public function register(AnalyticFeatureInterface $feature, array $context = []): void
    {
        $this->features[] = [
            'instance' => $feature,
            'context' => $context,
        ];
    }

    public function calculate(array $indicators, array $baseContext = []): array
    {
        $results = [];

        foreach ($this->features as $featureConfig) {
            $feature = $featureConfig['instance'];
            $featureContext = array_merge($baseContext, $featureConfig['context']);

            $key = $feature->key();
            $suffix = $featureContext['period'] ?? null;

            $resultKey = $suffix ? "{$key}_{$suffix}" : $key;

            $results[$resultKey] = $feature->resolve($indicators, $featureContext);
        }

        return $results;
    }
}
