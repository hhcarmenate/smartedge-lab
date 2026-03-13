<?php

namespace App\Services\MarketAnalytics;

use App\Services\MarketAnalytics\Contracts\IndicatorInterface;

class IndicatorEngine
{
    protected array $indicators = [];

    public function __construct(AnalyticsRegistry $analyticsRegistry)
    {
        foreach ($analyticsRegistry->indicators() as $indicatorConfig) {
            $this->register(
                $indicatorConfig['instance'],
                $indicatorConfig['params'] ?? []
            );
        }
    }

    public function register(IndicatorInterface $indicator, array $params = []): void
    {
        $this->indicators[] = [
            'instance' => $indicator,
            'params' => $params,
        ];
    }

    public function calculate(array $candles): array
    {
        $results = [];

        foreach ($this->indicators as $indicatorConfig) {
            $indicator = $indicatorConfig['instance'];
            $params = $indicatorConfig['params'];

            $key = $indicator->key();
            $suffix = $params['period'] ?? null;

            $resultKey = $suffix ? "{$key}_{$suffix}" : $key;

            $results[$resultKey] = $indicator->calculate($candles, $params);
        }

        return $results;
    }
}
