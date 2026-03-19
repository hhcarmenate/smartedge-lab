<script setup>
import MetricsRow from '../components/dashboard/MetricsRow.vue'
import SignalsTable from '../components/dashboard/SignalsTable.vue'
import PnLChart from '../components/dashboard/PnLChart.vue'
import MarketHeatMap from '../components/dashboard/MarketHeatMap.vue'
import PortfolioMini from '../components/dashboard/PortfolioMini.vue'
import ScannerHighlights from '../components/dashboard/ScannerHighlights.vue'
import AlertsFeed from '../components/dashboard/AlertsFeed.vue'
</script>

<template>
  <div class="flex flex-col gap-3.5 p-4 bg-bg-base min-h-screen">
        <!-- Metrics row -->
        <MetricsRow />

        <!-- Main grid -->
        <div class="grid grid-cols-[3fr_2fr] gap-3.5">
          <!-- Left: Signals table -->
          <SignalsTable />

          <!-- Right column: stacked cards -->
          <div class="flex flex-col gap-3.5">
            <PnLChart />
            <MarketHeatMap />
          </div>
        </div>

        <!-- Bottom grid -->
        <div class="grid grid-cols-3 gap-3.5">
          <PortfolioMini />
          <ScannerHighlights />
          <AlertsFeed />
        </div>
  </div>
</template>
