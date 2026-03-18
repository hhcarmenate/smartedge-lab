<script setup>
import PanelCard from '../ui/PanelCard.vue'
import AppBadge from '../ui/AppBadge.vue'

const positions = [
  { id: 'C', name: 'TSLA $250C', type: 'Call Debit · Mar 21', pnl: 840, pct: 18.4, color: 'green' },
  { id: 'IC', name: 'NVDA Condor', type: 'Iron Condor · Mar 28', pnl: 1240, pct: 24.1, color: 'green' },
  { id: 'S', name: 'AAPL Straddle', type: 'Straddle · Apr 4', pnl: -180, pct: -3.6, color: 'amber' },
  { id: 'P', name: 'SPY $540P', type: 'Put Spread · Mar 19', pnl: 320, pct: 8.2, color: 'red' }
]

const totalPnL = positions.reduce((sum, p) => sum + p.pnl, 0)

const colorMap = {
  green: 'bg-profit/10 text-profit',
  amber: 'bg-warn/10 text-warn',
  red: 'bg-loss/10 text-loss'
}
</script>

<template>
  <PanelCard>
    <template #header>
      <div>Open Positions</div>
    </template>
    <template #actions>
      <AppBadge variant="green" :label="`+$${totalPnL.toLocaleString()}`" />
    </template>
    <div>
      <div v-for="pos in positions" :key="pos.id" class="flex items-center justify-between py-2.5 px-4 border-b border-border/60 last:border-0">
        <div class="flex items-center gap-2">
          <div :class="`w-7 h-7 rounded-chip flex items-center justify-center font-mono text-[10px] font-bold ${colorMap[pos.color]}`">
            {{ pos.id }}
          </div>
          <div>
            <div class="text-[12px] font-semibold">{{ pos.name }}</div>
            <div class="font-mono text-[10px] text-text-ghost">{{ pos.type }}</div>
          </div>
        </div>
        <div class="text-right">
          <div :class="`font-mono text-[12px] font-semibold ${pos.pnl >= 0 ? 'text-profit' : 'text-loss'}`">
            {{ pos.pnl >= 0 ? '+' : '' }}${{ pos.pnl }}
          </div>
          <div :class="`font-mono text-[10px] ${pos.pct >= 0 ? 'text-profit-dim' : 'text-loss-dim'}`">
            {{ pos.pct >= 0 ? '+' : '' }}{{ pos.pct }}%
          </div>
        </div>
      </div>
    </div>
  </PanelCard>
</template>
