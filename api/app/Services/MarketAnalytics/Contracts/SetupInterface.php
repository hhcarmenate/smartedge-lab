<?php

namespace App\Services\MarketAnalytics\Contracts;

interface SetupInterface
{
    public function key(): string;
    public function exists(array $features): bool;
    public function score(array $features, array $indicators = []): float;
}
