<script setup>
defineProps({
  label: { type: String, required: true },
  value: { type: [String, Number], required: true },
  change: { type: [String, Number] },
  changeType: { type: String }, // up, neutral, down
  accent: { type: String, default: 'cyan' } // cyan, profit, violet, warn
})

const accentColor = {
  cyan: 'text-cyan',
  profit: 'text-profit',
  violet: 'text-violet',
  warn: 'text-warn'
}

const changeColor = {
  up: 'text-profit-dim',
  neutral: 'text-text-ghost',
  down: 'text-loss'
}

const accentBg = {
  cyan: 'bg-cyan',
  profit: 'bg-profit',
  violet: 'bg-violet',
  warn: 'bg-warn'
}
</script>

<template>
  <div class="relative bg-bg-surface border border-border rounded-card p-4">
    <div :class="`absolute top-0 left-0 right-0 h-0.5 ${accentBg[accent]}`" />
    <div class="font-mono text-[10px] uppercase tracking-widest text-text-ghost mb-1.5">{{ label }}</div>
    <div :class="`font-mono text-[22px] font-semibold leading-none mb-1 ${accentColor[accent]}`">{{ value }}</div>
    <div v-if="change" :class="`font-mono text-[10px] flex items-center gap-1 ${changeColor[changeType]}`">
      {{ change }}
    </div>
  </div>
</template>
