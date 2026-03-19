<script setup>
import { ref, computed } from 'vue'
import AppBadge from '../components/ui/AppBadge.vue'
import PanelCard from '../components/ui/PanelCard.vue'
import ScoreBar from '../components/ui/ScoreBar.vue'
import { TrendingUp, TrendingDown, Zap, List } from 'lucide-vue-next'

// ── Symbol selection ───────────────────────────────────────────
const selectedSymbol    = ref('TSLA')
const selectedTimeframe = ref('1M')
const timeframes        = ['1D', '1W', '1M', '3M']

const symbols = [
  { ticker: 'TSLA', price: 292.10, change: +2.41,  pct: +0.83,  iv: 68.4, ivRank: 65, vol: '108M', mktCap: '$930B' },
  { ticker: 'NVDA', price: 876.40, change: +15.62, pct: +1.82,  iv: 72.1, ivRank: 71, vol: '48M',  mktCap: '$2.16T' },
  { ticker: 'AAPL', price: 188.90, change: -1.20,  pct: -0.63,  iv: 41.2, ivRank: 38, vol: '62M',  mktCap: '$2.91T' },
  { ticker: 'AMD',  price: 174.30, change: +1.59,  pct: +0.92,  iv: 62.8, ivRank: 58, vol: '38M',  mktCap: '$282B' },
  { ticker: 'META', price: 477.80, change: -6.00,  pct: -1.24,  iv: 48.7, ivRank: 44, vol: '22M',  mktCap: '$1.21T' },
  { ticker: 'SPY',  price: 539.20, change: +2.04,  pct: +0.38,  iv: 18.4, ivRank: 22, vol: '74M',  mktCap: 'ETF' },
]

const sym = computed(() => symbols.find(s => s.ticker === selectedSymbol.value))

// Setups matched per symbol (mock)
const matchedSetups = {
  TSLA: [
    { name: 'IV Crush Play',     score: 91, direction: 'neutral', date: 'Apr 5' },
    { name: 'Momentum Breakout', score: 84, direction: 'bull',    date: 'Mar 25' },
  ],
  NVDA: [{ name: 'Momentum Breakout', score: 78, direction: 'bull',  date: 'Apr 4' }],
  AAPL: [{ name: 'Mean Reversion',    score: 72, direction: 'bear',  date: 'Mar 28' }],
  AMD:  [{ name: 'Momentum Breakout', score: 69, direction: 'bull',  date: 'Apr 3' }],
  META: [],
  SPY:  [{ name: 'Mean Reversion',    score: 61, direction: 'bear',  date: 'Mar 22' }],
}
const currentSetups = computed(() => matchedSetups[selectedSymbol.value] || [])

// ── Candle data — 40 days mock (TSLA) ─────────────────────────
const candles = [
  { o: 228, h: 233, l: 225, c: 231, v: 78  },
  { o: 231, h: 237, l: 229, c: 235, v: 85  },
  { o: 235, h: 239, l: 232, c: 238, v: 92  },
  { o: 238, h: 243, l: 236, c: 241, v: 88  },
  { o: 241, h: 246, l: 239, c: 244, v: 95  },
  { o: 244, h: 247, l: 240, c: 242, v: 72  },
  { o: 242, h: 245, l: 238, c: 243, v: 68  },
  { o: 243, h: 249, l: 241, c: 247, v: 104 },
  { o: 247, h: 253, l: 245, c: 251, v: 118 },
  { o: 251, h: 256, l: 249, c: 254, v: 112 }, // signal: IV Crush Play
  { o: 254, h: 261, l: 252, c: 259, v: 135 },
  { o: 259, h: 265, l: 257, c: 263, v: 142 },
  { o: 263, h: 268, l: 260, c: 266, v: 128 },
  { o: 266, h: 271, l: 264, c: 269, v: 115 },
  { o: 269, h: 274, l: 267, c: 272, v: 108 },
  { o: 272, h: 274, l: 264, c: 266, v: 132 },
  { o: 266, h: 269, l: 260, c: 262, v: 125 },
  { o: 262, h: 265, l: 257, c: 259, v: 118 },
  { o: 259, h: 262, l: 254, c: 256, v: 108 },
  { o: 256, h: 259, l: 251, c: 253, v: 95  },
  { o: 253, h: 258, l: 251, c: 256, v: 88  },
  { o: 256, h: 262, l: 254, c: 260, v: 95  },
  { o: 260, h: 265, l: 258, c: 263, v: 102 },
  { o: 263, h: 268, l: 261, c: 266, v: 112 },
  { o: 266, h: 271, l: 264, c: 269, v: 118 }, // signal: Momentum Breakout
  { o: 269, h: 273, l: 267, c: 271, v: 108 },
  { o: 271, h: 275, l: 269, c: 273, v: 115 },
  { o: 273, h: 278, l: 271, c: 276, v: 122 },
  { o: 276, h: 280, l: 274, c: 278, v: 128 },
  { o: 278, h: 283, l: 276, c: 281, v: 118 },
  { o: 281, h: 284, l: 276, c: 278, v: 105 },
  { o: 278, h: 281, l: 273, c: 275, v: 98  },
  { o: 275, h: 279, l: 272, c: 277, v: 92  },
  { o: 277, h: 282, l: 275, c: 280, v: 102 },
  { o: 280, h: 285, l: 278, c: 283, v: 115 },
  { o: 283, h: 287, l: 280, c: 285, v: 118 }, // signal: IV Crush Play
  { o: 285, h: 289, l: 283, c: 287, v: 122 },
  { o: 287, h: 291, l: 284, c: 289, v: 128 },
  { o: 289, h: 292, l: 286, c: 290, v: 115 },
  { o: 290, h: 294, l: 287, c: 292, v: 108 },
]

const signalMarkers = [
  { index: 9,  label: 'IV Crush',  color: '#FF3366' },
  { index: 24, label: 'Momentum', color: '#7B5CF5' },
  { index: 35, label: 'IV Crush',  color: '#FF3366' },
]

// ── Main chart geometry ────────────────────────────────────────
const CW = 700, CH = 230
const PL = 44, PR = 8, PT = 10
const CA_H = 165
const VT = 180, VH = 32

const innerW  = CW - PL - PR
const slotW   = innerW / candles.length
const bodyW   = Math.max(slotW - 3, 2)

const P_MIN = 220, P_MAX = 298, P_RANGE = P_MAX - P_MIN
const VOL_MAX = Math.max(...candles.map(c => c.v))

const pY    = (p) => PT + CA_H - ((p - P_MIN) / P_RANGE) * CA_H
const cX    = (i) => PL + i * slotW + slotW / 2
const vBotY = VT + VH
const vY    = (v) => VT + VH - (v / VOL_MAX) * VH

const renderedCandles = candles.map((c, i) => {
  const bull = c.c >= c.o
  const x    = cX(i)
  const bTop = pY(Math.max(c.o, c.c))
  const bBot = pY(Math.min(c.o, c.c))
  return {
    i, bull,
    color:  bull ? '#00E676' : '#FF3366',
    colorA: bull ? 'rgba(0,230,118,0.22)' : 'rgba(255,51,102,0.22)',
    wx: x,  wy1: pY(c.h), wy2: pY(c.l),
    bx: x - bodyW / 2, by: bTop, bw: bodyW, bh: Math.max(bBot - bTop, 1),
    vx: x - bodyW / 2, vy: vY(c.v), vw: bodyW, vh: vBotY - vY(c.v),
  }
})

const P_LEVELS = [230, 245, 260, 275, 290]
const DATE_LABELS = [
  { i: 0,  label: 'Feb 3'  },
  { i: 8,  label: 'Feb 13' },
  { i: 16, label: 'Feb 25' },
  { i: 24, label: 'Mar 7'  },
  { i: 32, label: 'Mar 17' },
  { i: 39, label: 'Mar 26' },
]
const renderedSignals = signalMarkers.map(s => ({ ...s, x: cX(s.index) }))

// ── Sub-chart geometry (shared) ────────────────────────────────
const SW = 700, SH = 68
const SPL = 44, SPR = 8, SPV = 6
const sInnerW = SW - SPL - SPR
const sInnerH = SH - SPV * 2

const linePath = (data, lo = 0, hi = 100) => {
  const range = hi - lo
  return data.map((v, i) => {
    const x = SPL + (i / (data.length - 1)) * sInnerW
    const y = SPV + sInnerH - ((v - lo) / range) * sInnerH
    return `${i === 0 ? 'M' : 'L'} ${x.toFixed(1)} ${y.toFixed(1)}`
  }).join(' ')
}

const fillPath = (data, lo = 0, hi = 100) => {
  const lp = linePath(data, lo, hi)
  const x0 = SPL.toFixed(1)
  const x1 = (SPL + sInnerW).toFixed(1)
  const yB = (SPV + sInnerH).toFixed(1)
  return `${lp} L ${x1} ${yB} L ${x0} ${yB} Z`
}

const refY = (v, lo = 0, hi = 100) =>
  SPV + sInnerH - ((v - lo) / (hi - lo)) * sInnerH

// IV Rank
const ivData    = [55,58,61,64,67,65,63,68,75,87,82,78,72,68,64,70,74,71,68,65,62,65,68,72,78,74,70,67,64,68,72,70,67,70,74,80,76,72,68,65]
const ivLine    = linePath(ivData)
const ivFill    = fillPath(ivData)
const ivRef70   = refY(70)
const ivCurrent = ivData[ivData.length - 1]

// RSI
const rsiData    = [45,48,52,55,58,54,52,57,63,70,74,78,75,72,69,62,57,52,48,44,47,52,56,60,65,62,59,56,54,58,62,60,57,60,64,68,65,62,59,62]
const rsiLine    = linePath(rsiData)
const rsiFill    = fillPath(rsiData)
const rsiRef70   = refY(70)
const rsiRef30   = refY(30)
const rsiCurrent = rsiData[rsiData.length - 1]

// ── UI helpers ─────────────────────────────────────────────────
const directionBadge = { bull: 'green', bear: 'red', neutral: 'amber' }
</script>

<template>
  <div class="flex flex-col gap-3.5 p-4 bg-bg-base min-h-screen">

        <!-- ── Control bar ───────────────────────────────────── -->
        <div class="flex items-center gap-4 bg-bg-surface border border-border rounded-card px-4 py-3">

          <!-- Symbol + price -->
          <div class="flex items-center gap-3">
            <span class="font-mono text-sm font-bold text-text-primary">{{ sym.ticker }}</span>
            <span class="font-mono text-sm text-text-primary">${{ sym.price.toFixed(2) }}</span>
            <div :class="['flex items-center gap-1 font-mono text-xs font-bold', sym.pct >= 0 ? 'text-profit' : 'text-loss']">
              <component :is="sym.pct >= 0 ? TrendingUp : TrendingDown" class="h-3.5 w-3.5" />
              {{ sym.pct >= 0 ? '+' : '' }}{{ sym.pct.toFixed(2) }}%
            </div>
          </div>

          <div class="h-4 w-px bg-border" />

          <!-- Timeframe -->
          <div class="flex items-center bg-bg-elevated border border-border rounded-chip overflow-hidden">
            <button
              v-for="tf in timeframes"
              :key="tf"
              @click="selectedTimeframe = tf"
              :class="[
                'px-3 py-1.5 font-mono text-[11px] transition-all duration-150',
                selectedTimeframe === tf
                  ? 'bg-cyan/15 text-cyan'
                  : 'text-text-ghost hover:text-text-primary'
              ]"
            >
              {{ tf }}
            </button>
          </div>

          <div class="flex-1" />

          <!-- Quick stats -->
          <div class="flex items-center gap-5">
            <div class="text-right">
              <p class="font-mono text-[9px] uppercase tracking-widest text-text-ghost">IV</p>
              <p class="font-mono text-[12px] font-bold text-warn">{{ sym.iv }}%</p>
            </div>
            <div class="text-right">
              <p class="font-mono text-[9px] uppercase tracking-widest text-text-ghost">IV Rank</p>
              <p :class="['font-mono text-[12px] font-bold', sym.ivRank >= 70 ? 'text-loss' : sym.ivRank >= 50 ? 'text-warn' : 'text-profit']">
                {{ sym.ivRank }}
              </p>
            </div>
            <div class="text-right">
              <p class="font-mono text-[9px] uppercase tracking-widest text-text-ghost">Volume</p>
              <p class="font-mono text-[12px] font-bold text-text-primary">{{ sym.vol }}</p>
            </div>
          </div>

          <AppBadge variant="violet" label="MOCK" />
        </div>

        <!-- ── Main layout ────────────────────────────────────── -->
        <div class="grid grid-cols-[1fr_252px] gap-3.5">

          <!-- Left: charts column -->
          <div class="flex flex-col gap-3.5 min-w-0">

            <!-- Main candlestick chart -->
            <PanelCard>
              <template #header>
                <span>{{ sym.ticker }}</span>
                <span class="text-text-ghost font-normal ml-1">— Daily Candles</span>
              </template>
              <template #actions>
                <div class="flex items-center gap-1.5">
                  <span class="h-2 w-2 rounded-full bg-profit animate-pulse" />
                  <span class="font-mono text-[10px] text-profit">Live</span>
                </div>
              </template>

              <div class="px-2 pt-1 pb-2">
                <svg
                  :viewBox="`0 0 ${CW} ${CH}`"
                  preserveAspectRatio="none"
                  class="w-full"
                  style="height: 240px"
                >
                  <!-- Horizontal grid lines -->
                  <line
                    v-for="p in P_LEVELS" :key="p"
                    :x1="PL" :y1="pY(p)" :x2="CW - PR" :y2="pY(p)"
                    stroke="#1A2640" stroke-width="0.5" stroke-dasharray="3 5"
                  />

                  <!-- Volume area separator -->
                  <line
                    :x1="PL" :y1="VT - 1" :x2="CW - PR" :y2="VT - 1"
                    stroke="#1A2640" stroke-width="0.5"
                  />

                  <!-- Signal overlays -->
                  <g v-for="sig in renderedSignals" :key="sig.index">
                    <line
                      :x1="sig.x" :y1="PT" :x2="sig.x" :y2="VT - 2"
                      :stroke="sig.color" stroke-width="0.8"
                      stroke-dasharray="3 4" stroke-opacity="0.55"
                    />
                    <rect
                      :x="sig.x - 23" :y="PT"
                      width="46" height="13" rx="3"
                      :fill="sig.color" fill-opacity="0.12"
                    />
                    <text
                      :x="sig.x" :y="PT + 9"
                      text-anchor="middle"
                      font-family="monospace" font-size="7"
                      :fill="sig.color" fill-opacity="0.85"
                    >{{ sig.label }}</text>
                  </g>

                  <!-- Volume bars -->
                  <rect
                    v-for="c in renderedCandles" :key="`v${c.i}`"
                    :x="c.vx" :y="c.vy" :width="c.vw" :height="c.vh"
                    :fill="c.colorA"
                  />

                  <!-- Candle wicks -->
                  <line
                    v-for="c in renderedCandles" :key="`w${c.i}`"
                    :x1="c.wx" :y1="c.wy1" :x2="c.wx" :y2="c.wy2"
                    :stroke="c.color" stroke-width="1"
                  />

                  <!-- Candle bodies -->
                  <rect
                    v-for="c in renderedCandles" :key="`b${c.i}`"
                    :x="c.bx" :y="c.by" :width="c.bw" :height="c.bh"
                    :fill="c.color"
                  />

                  <!-- Y-axis labels -->
                  <text
                    v-for="p in P_LEVELS" :key="`lp${p}`"
                    :x="PL - 4" :y="pY(p) + 3"
                    text-anchor="end"
                    font-family="monospace" font-size="8" fill="#4A5A7A"
                  >${{ p }}</text>

                  <!-- X-axis date labels -->
                  <text
                    v-for="dl in DATE_LABELS" :key="dl.label"
                    :x="cX(dl.i)" :y="CH - 2"
                    text-anchor="middle"
                    font-family="monospace" font-size="8" fill="#4A5A7A"
                  >{{ dl.label }}</text>
                </svg>
              </div>
            </PanelCard>

            <!-- Indicator sub-charts -->
            <PanelCard>
              <template #header>Indicators</template>
              <template #actions>
                <AppBadge variant="cyan" label="2 ACTIVE" />
              </template>

              <div class="divide-y divide-border">

                <!-- IV Rank -->
                <div class="px-2 pt-2 pb-1">
                  <div class="flex items-center justify-between px-2 mb-1">
                    <span class="font-mono text-[10px] text-text-ghost">IV RANK</span>
                    <div class="flex items-center gap-3">
                      <span class="font-mono text-[9px] text-text-ghost">threshold 70</span>
                      <span :class="['font-mono text-[11px] font-bold', ivCurrent >= 70 ? 'text-loss' : 'text-warn']">
                        {{ ivCurrent }}
                      </span>
                    </div>
                  </div>
                  <svg :viewBox="`0 0 ${SW} ${SH}`" preserveAspectRatio="none" class="w-full" style="height: 60px">
                    <defs>
                      <linearGradient id="ivGrad" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%"   stop-color="#FFB300" stop-opacity="0.2" />
                        <stop offset="100%" stop-color="#FFB300" stop-opacity="0" />
                      </linearGradient>
                    </defs>
                    <!-- Overbought zone -->
                    <rect :x="SPL" :y="SPV" :width="sInnerW" :height="ivRef70 - SPV"
                      fill="#FF3366" fill-opacity="0.04"
                    />
                    <!-- Ref line at 70 -->
                    <line :x1="SPL" :y1="ivRef70" :x2="SPL + sInnerW" :y2="ivRef70"
                      stroke="#FF3366" stroke-width="0.5" stroke-dasharray="3 4" stroke-opacity="0.5"
                    />
                    <text :x="SPL - 4" :y="ivRef70 + 3"
                      text-anchor="end" font-family="monospace" font-size="7" fill="#4A5A7A">70</text>
                    <path :d="ivFill" fill="url(#ivGrad)" />
                    <path :d="ivLine" fill="none" stroke="#FFB300" stroke-width="1" />
                  </svg>
                </div>

                <!-- RSI -->
                <div class="px-2 pt-2 pb-1">
                  <div class="flex items-center justify-between px-2 mb-1">
                    <span class="font-mono text-[10px] text-text-ghost">RSI (14)</span>
                    <div class="flex items-center gap-3">
                      <span class="font-mono text-[9px] text-text-ghost">OB 70 · OS 30</span>
                      <span :class="['font-mono text-[11px] font-bold', rsiCurrent >= 70 ? 'text-loss' : rsiCurrent <= 30 ? 'text-profit' : 'text-text-muted']">
                        {{ rsiCurrent }}
                      </span>
                    </div>
                  </div>
                  <svg :viewBox="`0 0 ${SW} ${SH}`" preserveAspectRatio="none" class="w-full" style="height: 60px">
                    <defs>
                      <linearGradient id="rsiGrad" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%"   stop-color="#00D4FF" stop-opacity="0.15" />
                        <stop offset="100%" stop-color="#00D4FF" stop-opacity="0" />
                      </linearGradient>
                    </defs>
                    <!-- Zones -->
                    <rect :x="SPL" :y="SPV" :width="sInnerW" :height="rsiRef70 - SPV"
                      fill="#FF3366" fill-opacity="0.04"
                    />
                    <rect :x="SPL" :y="rsiRef30" :width="sInnerW" :height="SPV + sInnerH - rsiRef30"
                      fill="#00E676" fill-opacity="0.04"
                    />
                    <!-- Ref lines -->
                    <line :x1="SPL" :y1="rsiRef70" :x2="SPL + sInnerW" :y2="rsiRef70"
                      stroke="#FF3366" stroke-width="0.5" stroke-dasharray="3 4" stroke-opacity="0.5"
                    />
                    <line :x1="SPL" :y1="rsiRef30" :x2="SPL + sInnerW" :y2="rsiRef30"
                      stroke="#00E676" stroke-width="0.5" stroke-dasharray="3 4" stroke-opacity="0.5"
                    />
                    <text :x="SPL - 4" :y="rsiRef70 + 3"
                      text-anchor="end" font-family="monospace" font-size="7" fill="#4A5A7A">70</text>
                    <text :x="SPL - 4" :y="rsiRef30 + 3"
                      text-anchor="end" font-family="monospace" font-size="7" fill="#4A5A7A">30</text>
                    <path :d="rsiFill" fill="url(#rsiGrad)" />
                    <path :d="rsiLine" fill="none" stroke="#00D4FF" stroke-width="1" />
                  </svg>
                </div>

              </div>
            </PanelCard>
          </div>

          <!-- Right: info panel -->
          <div class="flex flex-col gap-3.5">

            <!-- Symbol stats -->
            <div class="bg-bg-surface border border-border rounded-card overflow-hidden">
              <div class="px-4 py-3 border-b border-border">
                <p class="text-sm font-semibold">{{ sym.ticker }}</p>
              </div>
              <div class="divide-y divide-border">
                <div
                  v-for="row in [
                    { label: 'Last Price', value: `$${sym.price.toFixed(2)}`,                          color: 'text-text-primary' },
                    { label: 'Change',     value: `${sym.pct >= 0 ? '+' : ''}${sym.pct.toFixed(2)}%`, color: sym.pct >= 0 ? 'text-profit' : 'text-loss' },
                    { label: 'Volume',     value: sym.vol,                                             color: 'text-text-primary' },
                    { label: 'Mkt Cap',    value: sym.mktCap,                                          color: 'text-text-primary' },
                    { label: 'IV',         value: `${sym.iv}%`,                                        color: 'text-warn' },
                    { label: 'IV Rank',    value: `${sym.ivRank}`,                                     color: sym.ivRank >= 70 ? 'text-loss' : sym.ivRank >= 50 ? 'text-warn' : 'text-profit' },
                  ]"
                  :key="row.label"
                  class="flex items-center justify-between px-4 py-2.5"
                >
                  <span class="font-mono text-[10px] text-text-ghost">{{ row.label }}</span>
                  <span :class="['font-mono text-[12px] font-semibold', row.color]">{{ row.value }}</span>
                </div>
              </div>
            </div>

            <!-- Matched setups -->
            <PanelCard>
              <template #header>
                <div class="flex items-center gap-2">
                  <Zap class="h-3.5 w-3.5 text-text-ghost" />
                  <span>Matched Setups</span>
                </div>
              </template>
              <template #actions>
                <AppBadge
                  :variant="currentSetups.length ? 'cyan' : 'amber'"
                  :label="`${currentSetups.length}`"
                />
              </template>

              <div v-if="currentSetups.length" class="divide-y divide-border">
                <div v-for="setup in currentSetups" :key="setup.name" class="px-4 py-3 space-y-2">
                  <div class="flex items-center justify-between gap-2">
                    <p class="text-[12px] font-semibold text-text-primary leading-tight">{{ setup.name }}</p>
                    <AppBadge :variant="directionBadge[setup.direction]" :label="setup.direction.toUpperCase()" />
                  </div>
                  <ScoreBar :score="setup.score" />
                  <p class="font-mono text-[9px] text-text-ghost">{{ setup.date }}</p>
                </div>
              </div>

              <div v-else class="px-4 py-8 text-center">
                <p class="text-xs text-text-ghost">No setups matched for {{ sym.ticker }}</p>
              </div>
            </PanelCard>

            <!-- Watchlist navigator -->
            <PanelCard>
              <template #header>
                <div class="flex items-center gap-2">
                  <List class="h-3.5 w-3.5 text-text-ghost" />
                  <span>Watchlist</span>
                </div>
              </template>

              <div class="divide-y divide-border">
                <button
                  v-for="s in symbols"
                  :key="s.ticker"
                  @click="selectedSymbol = s.ticker"
                  :class="[
                    'w-full flex items-center justify-between px-4 py-2.5 transition-colors duration-100 text-left border-l-2',
                    selectedSymbol === s.ticker
                      ? 'bg-cyan/8 border-l-cyan'
                      : 'hover:bg-bg-elevated border-l-transparent'
                  ]"
                >
                  <div>
                    <p :class="['font-mono text-[12px] font-bold', selectedSymbol === s.ticker ? 'text-cyan' : 'text-text-primary']">
                      {{ s.ticker }}
                    </p>
                    <p class="font-mono text-[10px] text-text-ghost">${{ s.price.toFixed(2) }}</p>
                  </div>
                  <div :class="['font-mono text-[11px] font-bold', s.pct >= 0 ? 'text-profit' : 'text-loss']">
                    {{ s.pct >= 0 ? '+' : '' }}{{ s.pct.toFixed(2) }}%
                  </div>
                </button>
              </div>
            </PanelCard>

          </div>
        </div>
      </div>
</template>
