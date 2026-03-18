<script setup>
import PanelCard from '../ui/PanelCard.vue'

const heatmap = [
  { sym: 'TSLA', chg: 3.4 },
  { sym: 'NVDA', chg: 2.2 },
  { sym: 'QQQ', chg: 1.1 },
  { sym: 'SPY', chg: 0.8 },
  { sym: 'AMZN', chg: 0.7 },
  { sym: 'MSFT', chg: 0.0 },
  { sym: 'AAPL', chg: -0.2 },
  { sym: 'META', chg: -0.9 }
]

const getCellClass = (chg) => {
  if (chg > 2) return 'bg-profit/18 text-profit'
  if (chg > 1) return 'bg-profit/10 text-profit-dim'
  if (chg > 0) return 'bg-profit/5 text-profit-dim'
  if (chg === 0) return 'bg-text-muted/6 text-text-ghost'
  if (chg > -0.5) return 'bg-loss/5 text-loss-dim'
  return 'bg-loss/10 text-loss'
}
</script>

<template>
  <PanelCard>
    <template #header>
      <div>Market Heat</div>
    </template>
    <div class="p-4">
      <div class="grid grid-cols-4 gap-1">
        <div 
          v-for="item in heatmap" 
          :key="item.sym"
          :class="`rounded-chip p-2 text-center cursor-pointer transition-[filter] hover:brightness-125 ${getCellClass(item.chg)}`"
        >
          <div class="font-mono text-[10px] font-bold mb-0.5">{{ item.sym }}</div>
          <div class="font-mono text-[10px]">{{ item.chg >= 0 ? '+' : '' }}{{ item.chg }}%</div>
        </div>
      </div>
    </div>
  </PanelCard>
</template>
