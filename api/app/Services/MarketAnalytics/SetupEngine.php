<?php

namespace App\Services\MarketAnalytics;

use App\Services\MarketAnalytics\Contracts\SetupInterface;

class SetupEngine
{
    protected array $setups;

    public function __construct(SetupRegistry $registry)
    {
        $this->setups = $registry->setups();
    }

    public function evaluate(array $features, array $indicators = []): array
    {
        $results = [];

        /** @var SetupInterface $setup */
        foreach ($this->setups as $setup) {
            $exists = $setup->exists($features);

            $results[$setup->key()] = [
                'exists' => $exists,
                'score' => $exists
                    ? $setup->score($features, $indicators)
                    : 0,
            ];
        }

        return $results;
    }
}
