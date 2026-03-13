<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Database\Seeder;

class WatchlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            return;
        }

        $watchlist = Watchlist::create([
            'user_id' => $user->id,
            'name' => 'My First Watchlist',
            'description' => 'A default watchlist for my favorite tickers',
            'is_default' => true,
        ]);

        $symbols = [
            'SPY',
            'QQQ',
            'NVDA',
            'AMD',
            'AAPL',
            'TSLA',
            'META',
            'MSFT',
            'AMZN',
            'COIN',
            'PLTR',
            'SMCI',
        ];

        foreach ($symbols as $index => $symbol) {
            $watchlist->items()->create([
                'symbol' => $symbol,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
