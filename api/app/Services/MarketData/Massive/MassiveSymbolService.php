<?php

namespace App\Services\MarketData\Massive;

class MassiveSymbolService
{
    public function __construct(
        protected MassiveClient $client,
        protected MassiveSymbolMapper $mapper,
    ) {
    }

    public function search(string $query, int $limit = 10): array
    {
        $query = trim($query);

        if ($query === '') {
            return [];
        }

        $payload = $this->client->searchTickers([
            'search' => $query,
            'limit' => $limit,
            'active' => true,
        ]);

        return $this->mapper->mapSearchResults($payload);
    }

    public function findByTicker(string $ticker): ?array
    {
        $ticker = strtoupper(trim($ticker));

        if ($ticker === '') {
            return null;
        }

        $payload = $this->client->getTickerOverview($ticker);

        return $this->mapper->mapOverview($payload);
    }
}
