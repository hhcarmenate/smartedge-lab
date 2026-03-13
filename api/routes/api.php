<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\WatchlistController;
use App\Http\Controllers\Api\V1\WatchlistItemController;
use App\Http\Controllers\Api\V1\SymbolSearchController;
use App\Services\Symbols\SymbolLookupService;

Route::prefix('v1')->group(function() {
   Route::get('/health', function() {
      return response()->json([
         'status' => 'ok',
         'service' => 'SmartEdge API',
          'version' => 'v1'
      ]);
   });

   Route::post('/login', [AuthController::class, 'login'])->name('api.v1.login');

   Route::middleware('auth:sanctum')->group(function () {
       Route::post('/logout', [AuthController::class, 'logout'])->name('api.v1.logout');
       Route::get('/user', [AuthController::class, 'user'])->name('api.v1.user');

       // Watchlists
       Route::apiResource('watchlists', WatchlistController::class);

       // Watchlist Items
       Route::get('/watchlists/{watchlist}/items', [WatchlistItemController::class, 'index'])->name('watchlists.items.index');
       Route::post('/watchlists/{watchlist}/items', [WatchlistItemController::class, 'store'])->name('watchlists.items.store');
       Route::patch('/watchlist-items/{watchlistItem}', [WatchlistItemController::class, 'update'])->name('watchlist-items.update');
       Route::delete('/watchlist-items/{watchlistItem}', [WatchlistItemController::class, 'destroy'])->name('watchlist-items.destroy');


       Route::get('/symbols/search', SymbolSearchController::class)->name('symbol-search');
   });


   // Test Routes
   Route::get('/test/massive', function (\App\Services\MarketData\Massive\MassiveSymbolService $service) {
       $search = $service->search('AAPL');

       $ticker = $service->findByTicker('AAPL');

       return response()->json([
           'search_results' => $search,
           'ticker_overview' => $ticker,
       ]);
   });

    Route::get('/test/symbol-lookup/{ticker}', function (string $ticker, SymbolLookupService $service) {
        return response()->json($service->findOrCreateByTicker($ticker));
    });
});
