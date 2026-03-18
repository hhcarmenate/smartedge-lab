<script setup>
const tickers = [
  { sym: 'SPY',  price: 541.20, chg: 0.84  },
  { sym: 'QQQ',  price: 462.75, chg: 1.12  },
  { sym: 'AAPL', price: 189.40, chg: -0.23 },
  { sym: 'TSLA', price: 248.10, chg: 3.41  },
  { sym: 'NVDA', price: 876.30, chg: 2.18  },
  { sym: 'VIX',  price: 18.42,  chg: -4.20 },
  { sym: 'AMZN', price: 182.60, chg: 0.67  },
  { sym: 'META', price: 520.15, chg: -0.88 },
]

// Duplicate for seamless loop
const doubledTickers = [...tickers, ...tickers]
</script>

<template>
  <div class="bg-bg-surface border-y border-border py-2.5 overflow-hidden whitespace-nowrap">
    <div class="inline-flex animate-ticker gap-6">
      <div v-for="(item, idx) in doubledTickers" :key="idx" class="inline-flex items-center gap-1.5 px-6 border-r border-border font-mono text-[11px]">
        <span class="text-text-primary font-semibold">{{ item.sym }}</span>
        <span class="text-text-muted">${{ item.price.toFixed(2) }}</span>
        <span :class="item.chg >= 0 ? 'text-profit' : 'text-loss'">
          {{ item.chg >= 0 ? '+' : '' }}{{ item.chg.toFixed(2) }}%
        </span>
      </div>
    </div>
  </div>
</template>

<style scoped>
.animate-ticker {
  animation: ticker 20s linear infinite;
}
</style>
