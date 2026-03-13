<?php

namespace App\Services\Symbols;

use App\Models\Symbol;
use App\Services\MarketData\Massive\MassiveSymbolService;

class SymbolLookupService
{
    public function __construct(
        protected MassiveSymbolService $massiveSymbolService,
    ) {
    }

    public function findOrCreateByTicker(string $ticker): ?Symbol
    {
        $ticker = strtoupper(trim($ticker));

        if ($ticker === '') {
            return null;
        }

        $symbol = Symbol::query()
            ->where('ticker', $ticker)
            ->first();

        if ($symbol) {
            return $symbol;
        }

        $remoteSymbol = $this->massiveSymbolService->findByTicker($ticker);

        if (! $remoteSymbol) {
            return null;
        }

        if (! in_array($remoteSymbol['symbol_type'], ['stock', 'index'], true)) {
            return null;
        }

        return Symbol::query()->create([
            'ticker' => $remoteSymbol['ticker'],
            'name' => $remoteSymbol['name'],
            'symbol_type' => $remoteSymbol['symbol_type'],
            'market' => $remoteSymbol['market'],
            'locale' => $remoteSymbol['locale'],
            'primary_exchange' => $remoteSymbol['primary_exchange'],
            'currency_name' => $remoteSymbol['currency_name'],
            'active' => $remoteSymbol['active'],
            'cik' => $remoteSymbol['cik'],
            'composite_figi' => $remoteSymbol['composite_figi'],
            'share_class_figi' => $remoteSymbol['share_class_figi'],
            'last_synced_at' => now(),
        ]);
    }
}
