<?php

namespace App\Services\MarketAnalytics\Contracts;

interface IndicatorInterface
{
    public function key(): string;

    public function calculate(array $candles, array $params = []): mixed;
}
