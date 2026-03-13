<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Symbols\SearchSymbolsRequest;
use App\Services\MarketData\Massive\MassiveSymbolService;
use Illuminate\Http\JsonResponse;

class SymbolSearchController extends Controller
{
    public function __invoke(
        SearchSymbolsRequest $request,
        MassiveSymbolService $massiveSymbolService
    ) : JsonResponse
    {
        $symbols = $massiveSymbolService->search(
            $request->string('query')->toString(),
            $request->integer('limit', 10)
        );

        return response()->json([
            'data' => $symbols
        ]);
    }
}
