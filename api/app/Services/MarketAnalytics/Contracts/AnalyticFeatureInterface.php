<?php

namespace App\Services\MarketAnalytics\Contracts;

interface AnalyticFeatureInterface
{
    public function key(): string;

    public function resolve(array $indicators, array $context = []): mixed;
}
