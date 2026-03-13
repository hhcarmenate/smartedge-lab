<?php

namespace App\Services\Watchlist;

use App\Models\Watchlist;
use Illuminate\Database\Eloquent\Collection;

class WatchlistService
{
    /**
     * Get all watchlists for a user.
     */
    public function getForUser(int $userId): Collection
    {
        return Watchlist::query()
            ->with(['items.symbol'])
            ->where('user_id', $userId)
            ->where('is_active', true)
            ->get();
    }

    /**
     * Create a new watchlist.
     */
    public function create(array $data): Watchlist
    {
        // If this is the first watchlist for the user, make it default
        $count = Watchlist::where('user_id', $data['user_id'])->count();
        if ($count === 0) {
            $data['is_default'] = true;
        }

        // If setting as default, unset other defaults for this user
        if (!empty($data['is_default'])) {
            $this->resetDefault($data['user_id']);
        }

        return Watchlist::create($data);
    }

    /**
     * Update a watchlist.
     */
    public function update(Watchlist $watchlist, array $data): Watchlist
    {
        if (isset($data['is_default']) && $data['is_default']) {
            $this->resetDefault($watchlist->user_id);
        }

        $watchlist->update($data);
        return $watchlist;
    }

    /**
     * Delete a watchlist.
     */
    public function delete(Watchlist $watchlist): bool
    {
        return $watchlist->delete();
    }

    /**
     * Reset default status for all user's watchlists.
     */
    protected function resetDefault(int $userId): void
    {
        Watchlist::where('user_id', $userId)
            ->where('is_default', true)
            ->update(['is_default' => false]);
    }
}
