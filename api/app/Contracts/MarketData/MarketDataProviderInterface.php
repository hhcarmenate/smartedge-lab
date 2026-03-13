<?php

namespace App\Contracts\MarketData;

interface MarketDataProviderInterface
{
    public function searchTickers(array $params = []): array;

    public function getTickerOverview(string $ticker): array;
}
