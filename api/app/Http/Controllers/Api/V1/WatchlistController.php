<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Watchlist;
use App\Services\Watchlist\WatchlistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function __construct(
        protected WatchlistService $watchlistService
    ) {}

    /**
     * Display a listing of the user's watchlists.
     */
    public function index(Request $request): JsonResponse
    {
        $watchlists = $this->watchlistService->getForUser($request->user()->id);

        return response()->json(['data' => $watchlists]);
    }

    /**
     * Store a newly created watchlist in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['user_id'] = $request->user()->id;

        $watchlist = $this->watchlistService->create($validated);

        return response()->json(['data' => $watchlist], 201);
    }

    /**
     * Display the specified watchlist.
     */
    public function show(Watchlist $watchlist): JsonResponse
    {
        $this->authorizeOwner($watchlist);

        $watchlist->load(['items.symbol']);

        return response()->json(['data' => $watchlist]);
    }

    /**
     * Update the specified watchlist in storage.
     */
    public function update(Request $request, Watchlist $watchlist): JsonResponse
    {
        $this->authorizeOwner($watchlist);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'is_default' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $watchlist = $this->watchlistService->update($watchlist, $validated);

        return response()->json(['data' => $watchlist]);
    }

    /**
     * Remove the specified watchlist from storage.
     */
    public function destroy(Watchlist $watchlist): JsonResponse
    {
        $this->authorizeOwner($watchlist);

        $this->watchlistService->delete($watchlist);

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
}
