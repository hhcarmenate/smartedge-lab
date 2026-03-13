<?php

namespace App\Services\MarketData\Massive;

use Illuminate\Support\Facades\Log;

class MassiveSymbolMapper
{
    public function mapSearchResults(array $payload): array
    {
        $results = $payload['results'] ?? [];

        if (! is_array($results)) {
            return [];
        }

        return array_values(
            array_filter(
                array_map(fn (array $item) => $this->mapSymbol($item), $results)
            )
        );
    }

    public function mapOverview(array $payload): ?array
    {
        if (empty($payload['results']) || ! is_array($payload['results'])) {
            return null;
        }

        return $this->mapSymbol($payload['results']);
    }

    public function mapSymbol(array $item): ?array
    {
        $ticker = strtoupper(trim((string) ($item['ticker'] ?? '')));

        Log::info('Checking item', [$item]);

        if ($ticker === '') {
            return null;
        }

        return [
            'ticker' => $ticker,
            'name' => $item['name'] ?? null,
            'symbol_type' => $this->mapSymbolType($item),
            'market' => $item['market'] ?? null,
            'locale' => $item['locale'] ?? null,
            'primary_exchange' => $item['primary_exchange'] ?? null,
            'currency_name' => $this->getCurrencyName($item),
            'active' => (bool) ($item['active'] ?? false),
            'cik' => $item['cik'] ?? null,
            'composite_figi' => $item['composite_figi'] ?? null,
            'share_class_figi' => $item['share_class_figi'] ?? null,
        ];
    }

    protected function getCurrencyName(array $item)
    {
        if (!isset($item['currency_name'])) {
            return null;
        }

        return $item['currency_name'] ? strtoupper($item['currency_name']) : null;
    }

    protected function mapSymbolType(array $item): ?string
    {
        if (!isset($item['type'])) {
            return null;
        }

        $type = $item['type'];

        return match (strtoupper((string) $type)) {
            'CS', 'ETF' => 'stock',
            'INDEX' => 'index',
            default => null,
        };
    }
}
