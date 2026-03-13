<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\WatchlistItem\WatchlistItemStoreRequest;
use App\Models\Watchlist;
use App\Models\WatchlistItem;
use App\Services\Watchlist\WatchlistItemService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WatchlistItemController extends Controller
{
    public function __construct(
        protected WatchlistItemService $watchlistItemService
    ) {}

    /**
     * Display a listing of items for a specific watchlist.
     */
    public function index(Watchlist $watchlist): JsonResponse
    {
        $this->authorizeOwner($watchlist);

        $items = $this->watchlistItemService->getItems($watchlist);

        return response()->json(['data' => $items]);
    }

    /**
     * Store a newly created item in a specific watchlist.
     */
    public function store(WatchlistItemStoreRequest $request, Watchlist $watchlist): JsonResponse
    {
        $this->authorizeOwner($watchlist);

        $item = $this->watchlistItemService->addItem($watchlist, $request->validated());

        return response()->json(['data' => $item], 201);
    }

    /**
     * Update the specified item.
     */
    public function update(Request $request, WatchlistItem $watchlistItem): JsonResponse
    {
        $this->authorizeItemOwner($watchlistItem);

        $validated = $request->validate([
            'symbol_id' => 'sometimes|required|exists:symbols,id',
            'notes' => 'nullable|string',
            'priority' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $item = $this->watchlistItemService->updateItem($watchlistItem, $validated);

        return response()->json(['data' => $item]);
    }

    /**
     * Remove the specified item from storage.
     */
    public function destroy(WatchlistItem $watchlistItem): JsonResponse
    {
        $this->authorizeItemOwner($watchlistItem);

        $this->watchlistItemService->removeItem($watchlistItem);

        return response()->json(null, 204);
    }

    /**
     * Authorize that the authenticated user owns the watchlist.
     */
    protected function authorizeOwner(Watchlist $watchlist): void
    {
        if ($watchlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Authorize that the authenticated user owns the item's watchlist.
     */
    protected function authorizeItemOwner(WatchlistItem $item): void
    {
        if ($item->watchlist->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
