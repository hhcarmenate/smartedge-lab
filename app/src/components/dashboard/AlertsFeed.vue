<script setup>
import PanelCard from '../ui/PanelCard.vue'
import AppBadge from '../ui/AppBadge.vue'

const alerts = [
  { dot: 'cyan', title: 'TSLA: Unusual call volume 3.8x avg', time: '09:47:12' },
  { dot: 'green', title: 'Signal triggered: GME $22C Apr 4', time: '09:43:05' },
  { dot: 'amber', title: 'VIX spike detected — +4.2% in 15m', time: '09:38:44' },
  { dot: 'red', title: 'AAPL Straddle: stop threshold hit', time: '09:31:20' },
  { dot: 'green', title: 'NVDA Condor: +24% — consider exit', time: '09:22:08' }
]

const dotColor = {
  cyan: 'bg-cyan',
  green: 'bg-profit',
  amber: 'bg-warn',
  red: 'bg-loss'
}
</script>

<template>
  <PanelCard>
    <template #header>
      <div>Live Alerts</div>
    </template>
    <template #actions>
      <AppBadge variant="amber" label="3 new" />
    </template>
    <div>
      <div v-for="(alert, idx) in alerts" :key="idx" class="flex gap-2.5 items-start py-2.5 px-4 border-b border-border/60 last:border-0">
        <div :class="`w-1.5 h-1.5 rounded-full mt-1 flex-shrink-0 ${dotColor[alert.dot]}`" />
        <div>
          <div class="text-[11px] font-medium text-text-primary">{{ alert.title }}</div>
          <div class="font-mono text-[10px] text-text-ghost">{{ alert.time }}</div>
        </div>
      </div>
    </div>
  </PanelCard>
</template>
