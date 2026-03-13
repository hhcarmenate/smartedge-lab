<?php

namespace App\Services\Watchlist;

use App\Models\Symbol;
use App\Models\Watchlist;
use App\Models\WatchlistItem;
use App\Services\MarketData\Massive\MassiveSymbolService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Collection;

class WatchlistItemService
{
    /**
     * Get all items for a watchlist.
     */
    public function getItems(Watchlist $watchlist): Collection
    {
        return $watchlist->items()
            ->with('symbol')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }

    /**
     * Add an item to a watchlist.
     * @throws BindingResolutionException
     */
    public function addItem(Watchlist $watchlist, array $data): WatchlistItem
    {
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = $watchlist->items()->max('sort_order') + 1;
        }

        $symbol = Symbol::query()->where('ticker', $data['ticker'])->first();

        if (!$symbol) {
            $massiveSymbolService = app()->make(MassiveSymbolService::class);

            $ticker = $massiveSymbolService->findByTicker($data['ticker']);

            $symbol = Symbol::query()->create(
                [
                    'ticker' => $data['ticker'],
                    'name' => $ticker['name'] ?? '',
                    'symbol_type' => $this->mapSymbolType($ticker['symbol_type']),
                    'market' => $ticker['market'] ?? '',
                    'locale' => $ticker['locale'] ?? '',
                    'primary_exchange' => $ticker['primary_exchange'] ?? '',
                    'currency_name' => $ticker['currency_name'] ?? '',
                    'active' => $ticker['active'] ?? '',
                    'cik' => $ticker['cik'] ?? '',
                    'composite_figi' => $ticker['composite_figi'] ?? '',
                    'share_class_figi' => $ticker['share_class_figi'] ?? '',
                    'last_synced_at' => now(),
                ]);
        }

        $data['symbol_id'] = $symbol->id;
        $data['watchlist_id'] = $watchlist->id;

        return $watchlist->items()->create($data);
    }

    private function mapSymbolType(?string $type): ?string
    {
        return match (strtoupper((string) $type)) {
            'CS', 'ETF', 'STOCK' => 'stock',
            'INDEX' => 'index',
            default => null,
        };
    }

    /**
     * Update a watchlist item.
     */
    public function updateItem(WatchlistItem $item, array $data): WatchlistItem
    {
        $item->update($data);
        return $item;
    }

    /**
     * Remove an item from a watchlist.
     */
    public function removeItem(WatchlistItem $item): bool
    {
        return $item->delete();
    }
}
