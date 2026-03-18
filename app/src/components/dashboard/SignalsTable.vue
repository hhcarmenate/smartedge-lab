<script setup>
import PanelCard from '../ui/PanelCard.vue'
import AppBadge from '../ui/AppBadge.vue'
import ScoreBar from '../ui/ScoreBar.vue'
import { ref } from 'vue'

const filter = ref('all')

const signals = [
  { ticker: 'TSLA', strategy: 'Call Debit', type: 'bull', score: 87, ivRank: 92.4, pnl: 840, expires: 'Mar 21' },
  { ticker: 'SPY', strategy: 'Put Spread', type: 'bear', score: 79, ivRank: 78.1, pnl: 320, expires: 'Mar 19' },
  { ticker: 'NVDA', strategy: 'Iron Condor', type: 'bull', score: 72, ivRank: 65.8, pnl: 1240, expires: 'Mar 28' },
  { ticker: 'AAPL', strategy: 'Straddle', type: 'neu', score: 68, ivRank: 61.2, pnl: -180, expires: 'Apr 4' },
  { ticker: 'META', strategy: 'Bear Call', type: 'bear', score: 55, ivRank: 44.7, pnl: -90, expires: 'Apr 11' }
]

const getStrategyVariant = (type) => {
  if (type === 'bull') return 'green'
  if (type === 'bear') return 'red'
  return 'amber'
}

const getIVColor = (iv) => {
  if (iv > 80) return 'text-cyan'
  if (iv >= 60) return 'text-warn'
  return 'text-text-muted'
}

const filteredSignals = () => {
  if (filter.value === 'all') return signals
  if (filter.value === 'bull') return signals.filter(s => s.type === 'bull')
  if (filter.value === 'bear') return signals.filter(s => s.type === 'bear')
  return signals
}
</script>

<template>
  <PanelCard>
    <template #header>
      <div class="flex items-center gap-2">
        <span>Top Signals</span>
        <AppBadge variant="cyan" :label="`${signals.length} live`" />
      </div>
    </template>
    <template #actions>
      <button 
        v-for="f in ['all', 'bull', 'bear']" 
        :key="f"
        @click="filter = f"
        :class="[
          'font-mono text-[10px] px-2.5 py-0.5 rounded border transition-all duration-150',
          filter === f
            ? 'border-border-strong bg-bg-hover text-text-primary'
            : 'border-border-strong bg-transparent text-text-ghost hover:bg-bg-hover hover:text-text-primary'
        ]"
      >
        {{ f.charAt(0).toUpperCase() + f.slice(1) }}
      </button>
    </template>
    <div>
      <table class="w-full border-collapse text-[11px]">
        <thead>
          <tr class="text-left">
            <th class="px-2.5 py-2 text-text-ghost font-mono text-[10px] tracking-wider border-b border-border">Ticker</th>
            <th class="px-2.5 py-2 text-text-ghost font-mono text-[10px] tracking-wider border-b border-border">Strategy</th>
            <th class="px-2.5 py-2 text-text-ghost font-mono text-[10px] tracking-wider border-b border-border">Score</th>
            <th class="px-2.5 py-2 text-text-ghost font-mono text-[10px] tracking-wider border-b border-border">IV Rank</th>
            <th class="px-2.5 py-2 text-text-ghost font-mono text-[10px] tracking-wider border-b border-border">P&L</th>
            <th class="px-2.5 py-2 text-text-ghost font-mono text-[10px] tracking-wider border-b border-border">Expires</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="signal in filteredSignals()" :key="signal.ticker" class="hover:bg-bg-elevated transition-colors duration-150">
            <td class="px-2.5 py-2.5 border-b border-border/60 font-mono font-bold text-[12px] text-text-primary">{{ signal.ticker }}</td>
            <td class="px-2.5 py-2.5 border-b border-border/60">
              <AppBadge :variant="getStrategyVariant(signal.type)" :label="signal.strategy" />
            </td>
            <td class="px-2.5 py-2.5 border-b border-border/60 w-32">
              <ScoreBar :score="signal.score" />
            </td>
            <td :class="`px-2.5 py-2.5 border-b border-border/60 font-mono text-[10px] ${getIVColor(signal.ivRank)}`">
              {{ signal.ivRank.toFixed(1) }}
            </td>
            <td :class="`px-2.5 py-2.5 border-b border-border/60 font-mono font-semibold ${signal.pnl >= 0 ? 'text-profit' : 'text-loss'}`">
              {{ signal.pnl >= 0 ? '+' : '' }}${{ signal.pnl }}
            </td>
            <td class="px-2.5 py-2.5 border-b border-border/60 font-mono text-[10px] text-text-ghost">{{ signal.expires }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </PanelCard>
</template>
