<?php

namespace App\Services\MarketData\Massive;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class MassiveClient
{
    public function searchTickers(array $params = [])
    {
        return $this->get('/v3/reference/tickers', $params);
    }

    public function getTickerOverview(string $ticker)
    {
        $ticker = strtoupper(trim($ticker));

        if ($ticker === '') {
            throw new RuntimeException('Ticker is required.');
        }

        return $this->get("/v3/reference/tickers/{$ticker}");
    }

    protected function get(string $uri, array $query = []): array
    {
        try {
            $response = $this->http()
                ->get($uri, array_filter([
                    ...$query,
                    'apiKey' => config('services.massive.api_key'),
                ], fn ($value) => $value !== null && $value !== ''));

            $response->throw();

            return $response->json() ?? [];
        } catch (RequestException $exception) {
            throw new RuntimeException(
                $exception->response?->json('error')
                ?? $exception->getMessage(),
                previous: $exception
            );
        }
    }

    protected function http(): PendingRequest
    {
        return Http::baseUrl(config('services.massive.base_url'))
            ->acceptJson()
            ->timeout((int) config('services.massive.timeout', 10));
    }
}
