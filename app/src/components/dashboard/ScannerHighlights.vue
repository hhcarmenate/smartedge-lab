<script setup>
import PanelCard from '../ui/PanelCard.vue'
import AppBadge from '../ui/AppBadge.vue'
import ScoreBar from '../ui/ScoreBar.vue'

const highlights = [
  { ticker: 'GME', contract: '$22C · Apr 4 · Δ 0.42', iv: 96.2, score: 94 },
  { ticker: 'MSTR', contract: '$180P · Mar 21 · Δ -0.35', iv: 88.4, score: 88 },
  { ticker: 'PLTR', contract: '$26C · Apr 11 · Δ 0.39', iv: 81.7, score: 82 },
  { ticker: 'AMD', contract: '$175C · Mar 28 · Δ 0.30', iv: 74.3, score: 76 }
]
</script>

<template>
  <PanelCard>
    <template #header>
      <div>Scanner Highlights</div>
    </template>
    <template #actions>
      <AppBadge variant="cyan" label="IV >70" />
    </template>
    <div>
      <div v-for="item in highlights" :key="item.ticker" class="flex items-center justify-between py-2 px-4 rounded border-b border-border/60 last:border-0 hover:bg-bg-elevated cursor-pointer transition-colors">
        <div>
          <div class="font-mono text-[12px] font-bold text-text-primary">{{ item.ticker }}</div>
          <div class="font-mono text-[10px] text-text-ghost">{{ item.contract }}</div>
        </div>
        <div class="flex items-center gap-2">
          <div class="w-24">
            <ScoreBar :score="item.score" />
          </div>
          <div class="font-mono text-[11px] text-cyan font-semibold">{{ item.iv.toFixed(1) }}</div>
        </div>
      </div>
    </div>
  </PanelCard>
</template>
