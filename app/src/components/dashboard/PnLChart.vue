<script setup>
import PanelCard from '../ui/PanelCard.vue'
import AppBadge from '../ui/AppBadge.vue'

// Mock P&L data points
const dataPoints = [
  { x: 0, y: 100 },
  { x: 50, y: 95 },
  { x: 100, y: 110 },
  { x: 150, y: 105 },
  { x: 200, y: 120 },
  { x: 250, y: 115 },
  { x: 300, y: 135 },
  { x: 340, y: 140 }
]

// Scale to fit viewBox
const minY = Math.min(...dataPoints.map(p => p.y))
const maxY = Math.max(...dataPoints.map(p => p.y))
const range = maxY - minY || 1

const scaledPoints = dataPoints.map(p => ({
  x: p.x,
  y: 120 - ((p.y - minY) / range) * 100
}))

const pathD = scaledPoints.map((p, i) => `${i === 0 ? 'M' : 'L'} ${p.x} ${p.y}`).join(' ')
</script>

<template>
  <PanelCard>
    <template #header>
      <div>SPY — P&L Curve</div>
    </template>
    <template #actions>
      <AppBadge variant="green" label="+6.3% today" />
    </template>
    <div class="p-4">
      <svg viewBox="0 0 340 120" preserveAspectRatio="none" class="w-full h-[140px]">
        <!-- Grid lines -->
        <line x1="0" y1="30" x2="340" y2="30" stroke="#243352" stroke-width="0.5" stroke-dasharray="2 4" />
        <line x1="0" y1="60" x2="340" y2="60" stroke="#243352" stroke-width="0.5" stroke-dasharray="2 4" />
        <line x1="0" y1="90" x2="340" y2="90" stroke="#243352" stroke-width="0.5" stroke-dasharray="2 4" />
        
        <!-- Gradient fill -->
        <defs>
          <linearGradient id="pnlGradient" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color: #00E676; stop-opacity: 0.25" />
            <stop offset="100%" style="stop-color: #00E676; stop-opacity: 0" />
          </linearGradient>
        </defs>
        
        <!-- P&L curve fill -->
        <path :d="`${pathD} L 340 120 L 0 120 Z`" fill="url(#pnlGradient)" />
        
        <!-- P&L line -->
        <path :d="pathD" stroke="#00D4FF" stroke-width="1" fill="none" />
        
        <!-- Axis labels -->
        <text x="5" y="115" fill="#4A5A7A" font-size="9" font-family="monospace">0%</text>
        <text x="315" y="115" fill="#4A5A7A" font-size="9" font-family="monospace">+8.2%</text>
      </svg>
    </div>
  </PanelCard>
</template>
