<?php

namespace App\Console\Commands;

use App\Services\MarketAnalytics\FeatureEngine;
use App\Services\MarketAnalytics\IndicatorEngine;
use App\Services\MarketAnalytics\SetupEngine;
use Illuminate\Console\Command;

class TestIndicatorEngine extends Command
{
    protected $signature = 'smartedge:test-indicators';
    protected $description = 'Test IndicatorEngine with mock candle data';

    /**
     * Execute the console command.
     */
    public function handle(
        IndicatorEngine $indicatorEngine,
        FeatureEngine $featureEngine,
        SetupEngine $setupEngine
    ): void {

        $candles = $this->mockCandles();

        $indicatorResults = $indicatorEngine->calculate($candles);

        $latestCandle = end($candles);

        $context = [
            'price' => $latestCandle['close'],
        ];

        $featureResults = $featureEngine->calculate($indicatorResults, $context);

        $this->info('Indicator results:');
        $this->line(json_encode($indicatorResults, JSON_PRETTY_PRINT));

        $this->info('Feature results:');
        $this->line(json_encode($featureResults, JSON_PRETTY_PRINT));

        $setupResults = $setupEngine->evaluate($featureResults, $indicatorResults);
        $this->info('Setup results:');
        $this->line(json_encode($setupResults, JSON_PRETTY_PRINT));
    }

    /**
     * Generates a mock dataset of candlestick data representing financial market movements.
     * Each candlestick contains the open, high, low, close prices, and volume.
     *
     * @return array An array of associative arrays where each individual array represents a candlestick
     *               with keys 'open', 'high', 'low', 'close', and 'volume'.
     */
    private function mockCandles(): array
    {
        $candles = [];

        $price = 100;

        for ($i = 0; $i < 200; $i++) {
            $open = $price;
            $close = $open + rand(-2, 3);
            $high = max($open, $close) + rand(0, 2);
            $low = min($open, $close) - rand(0, 2);
            $volume = rand(100000, 500000);

            $candles[] = [
                'open' => $open,
                'high' => $high,
                'low' => $low,
                'close' => $close,
                'volume' => $volume,
            ];

            $price = $close;
        }

        return $candles;
    }
}

