<script setup>
import { ref, computed } from 'vue'
import MetricCard from '../components/ui/MetricCard.vue'
import PanelCard from '../components/ui/PanelCard.vue'
import AppBadge from '../components/ui/AppBadge.vue'
import ScoreBar from '../components/ui/ScoreBar.vue'
import { TrendingUp, TrendingDown, AlertTriangle, Clock, BookOpen } from 'lucide-vue-next'
import { useRouter } from 'vue-router'

const router = useRouter()
const activeTab = ref('open')

// ── Open positions ─────────────────────────────────────────────
const positions = [
  {
    id: 1, ticker: 'TSLA', strategy: 'Call Debit Spread',
    entry: 248.40, current: 258.20, pnl: 840,  pctPnl: +18.4,
    dte: 14, delta: 0.42, theta: -0.18,
    setup: 'IV Crush Play', status: 'active',
  },
  {
    id: 2, ticker: 'NVDA', strategy: 'Iron Condor',
    entry: 870.00, current: 876.40, pnl: 1240, pctPnl: +24.1,
    dte: 21, delta: 0.08, theta: -0.31,
    setup: 'Momentum Breakout', status: 'active',
  },
  {
    id: 3, ticker: 'AAPL', strategy: 'Straddle',
    entry: 190.50, current: 188.90, pnl: -180, pctPnl: -3.6,
    dte: 7,  delta: -0.12, theta: -0.22,
    setup: 'Earnings Play', status: 'at-risk',
  },
  {
    id: 4, ticker: 'SPY',  strategy: 'Put Spread',
    entry: 541.00, current: 539.20, pnl: 320,  pctPnl: +8.2,
    dte: 3,  delta: -0.22, theta: -0.09,
    setup: 'Mean Reversion', status: 'exp-soon',
  },
  {
    id: 5, ticker: 'AMD',  strategy: 'Covered Call',
    entry: 172.40, current: 174.30, pnl: 290,  pctPnl: +6.8,
    dte: 28, delta: 0.30, theta: -0.14,
    setup: 'Momentum Breakout', status: 'active',
  },
]

// ── Trade history ──────────────────────────────────────────────
const history = [
  { id: 1, ticker: 'MSTR', strategy: 'IV Crush Play',     entry: '180P',  entryDate: 'Mar 1',  exitDate: 'Mar 14', pnl: +640,  pctPnl: +22.1, result: 'win' },
  { id: 2, ticker: 'GME',  strategy: 'Momentum Breakout', entry: '$22C',  entryDate: 'Feb 28', exitDate: 'Mar 8',  pnl: +920,  pctPnl: +31.4, result: 'win' },
  { id: 3, ticker: 'PLTR', strategy: 'Mean Reversion',    entry: '$26C',  entryDate: 'Feb 20', exitDate: 'Mar 1',  pnl: -240,  pctPnl: -8.2,  result: 'loss' },
  { id: 4, ticker: 'META', strategy: 'Earnings Play',     entry: '$460C', entryDate: 'Feb 15', exitDate: 'Feb 22', pnl: +1480, pctPnl: +38.6, result: 'win' },
  { id: 5, ticker: 'SPY',  strategy: 'Mean Reversion',    entry: '$510P', entryDate: 'Feb 10', exitDate: 'Feb 18', pnl: -120,  pctPnl: -4.1,  result: 'loss' },
  { id: 6, ticker: 'NVDA', strategy: 'Momentum Breakout', entry: '$800C', entryDate: 'Feb 3',  exitDate: 'Feb 14', pnl: +2100, pctPnl: +44.2, result: 'win' },
]

// ── Metrics ────────────────────────────────────────────────────
const totalPnl = computed(() => positions.reduce((a, p) => a + p.pnl, 0))
const openCount = computed(() => positions.length)
const histWins  = computed(() => history.filter(h => h.result === 'win').length)
const winRate   = computed(() => Math.round((histWins.value / history.length) * 100))

const metrics = computed(() => [
  { label: 'Open P&L',       value: `+$${totalPnl.value.toLocaleString()}`, change: 'across 5 positions', changeType: 'up',      accent: 'profit' },
  { label: 'Win Rate',       value: `${winRate.value}%`,                    change: `${histWins.value}/${history.length} closed`,  changeType: 'up',      accent: 'cyan' },
  { label: 'Open Positions', value: openCount.value.toString(),             change: '3 active · 1 at-risk · 1 exp-soon', changeType: 'neutral', accent: 'violet' },
  { label: 'Profit Factor',  value: '2.8',                                  change: 'total gain / total loss',           changeType: 'up',      accent: 'warn' },
])

// ── P&L curve (cumulative, mock) ──────────────────────────────
const pnlCurve = [0, 420, 850, 720, 1100, 1680, 1520, 2100, 2480, 3100, 3620, 4180, 3980, 4820]
const PW = 340, PH = 100
const pnlMin  = Math.min(...pnlCurve)
const pnlMax  = Math.max(...pnlCurve)
const pnlRng  = pnlMax - pnlMin

const pnlLinePath = pnlCurve.map((v, i) => {
  const x = (i / (pnlCurve.length - 1)) * PW
  const y = PH - 8 - ((v - pnlMin) / pnlRng) * (PH - 16)
  return `${i === 0 ? 'M' : 'L'} ${x.toFixed(1)} ${y.toFixed(1)}`
}).join(' ')

const pnlFillPath = `${pnlLinePath} L ${PW} ${PH} L 0 ${PH} Z`

// ── Win rate donut ─────────────────────────────────────────────
const DONUT_R    = 30
const DONUT_CIRC = 2 * Math.PI * DONUT_R
const donutArc   = computed(() => (winRate.value / 100) * DONUT_CIRC)

// ── Status config ──────────────────────────────────────────────
const statusConfig = {
  'active':   { label: 'Active',    variant: 'green', icon: TrendingUp },
  'at-risk':  { label: 'At Risk',   variant: 'red',   icon: AlertTriangle },
  'exp-soon': { label: 'Exp. Soon', variant: 'amber', icon: Clock },
}
</script>

<template>
  <div class="flex flex-col gap-3.5 p-4 bg-bg-base min-h-screen">

        <!-- ── Metrics ───────────────────────────────────────── -->
        <div class="grid grid-cols-4 gap-2.5">
          <MetricCard v-for="m in metrics" :key="m.label" v-bind="m" />
        </div>

        <!-- ── Tabs ──────────────────────────────────────────── -->
        <div class="flex items-center gap-0 bg-bg-surface border border-border rounded-card p-1 w-fit">
          <button
            v-for="tab in [{ id: 'open', label: 'Open Positions' }, { id: 'history', label: 'Trade History' }]"
            :key="tab.id"
            @click="activeTab = tab.id"
            :class="[
              'px-5 py-2 rounded-chip text-sm font-medium transition-all duration-150',
              activeTab === tab.id
                ? 'bg-bg-hover text-cyan'
                : 'text-text-muted hover:text-text-primary'
            ]"
          >{{ tab.label }}</button>
        </div>

        <!-- ── Main layout ────────────────────────────────────── -->
        <div class="grid grid-cols-[1fr_240px] gap-3.5">

          <!-- Left: table -->
          <div>

            <!-- Open positions -->
            <PanelCard v-if="activeTab === 'open'">
              <template #header>Open Positions</template>
              <template #actions>
                <AppBadge variant="cyan" :label="`${positions.length} OPEN`" />
              </template>
              <table class="w-full text-left">
                <thead>
                  <tr class="border-b border-border/60">
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Symbol</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Strategy</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Entry</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Current</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">P&L</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">DTE</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Greeks</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="p in positions" :key="p.id"
                    class="border-b border-border/40 hover:bg-bg-elevated transition-colors duration-100 group cursor-pointer"
                  >
                    <td class="px-4 py-3.5">
                      <div class="font-mono text-sm font-bold text-text-primary group-hover:text-cyan transition-colors">{{ p.ticker }}</div>
                      <div class="font-mono text-[9px] text-text-ghost">{{ p.setup }}</div>
                    </td>
                    <td class="px-4 py-3.5">
                      <span class="text-[11px] text-text-muted">{{ p.strategy }}</span>
                    </td>
                    <td class="px-4 py-3.5">
                      <span class="font-mono text-[12px] text-text-primary">${{ p.entry.toFixed(2) }}</span>
                    </td>
                    <td class="px-4 py-3.5">
                      <span :class="['font-mono text-[12px] font-semibold', p.current >= p.entry ? 'text-profit' : 'text-loss']">
                        ${{ p.current.toFixed(2) }}
                      </span>
                    </td>
                    <td class="px-4 py-3.5">
                      <div :class="['font-mono text-[12px] font-bold', p.pnl >= 0 ? 'text-profit' : 'text-loss']">
                        {{ p.pnl >= 0 ? '+' : '' }}${{ p.pnl.toLocaleString() }}
                      </div>
                      <div :class="['font-mono text-[10px]', p.pctPnl >= 0 ? 'text-profit-dim' : 'text-loss-dim']">
                        {{ p.pctPnl >= 0 ? '+' : '' }}{{ p.pctPnl }}%
                      </div>
                    </td>
                    <td class="px-4 py-3.5">
                      <span :class="['font-mono text-[12px] font-bold', p.dte <= 5 ? 'text-loss' : p.dte <= 10 ? 'text-warn' : 'text-text-primary']">
                        {{ p.dte }}d
                      </span>
                    </td>
                    <td class="px-4 py-3.5">
                      <div class="font-mono text-[11px] text-text-muted">Δ <span class="text-text-primary">{{ p.delta }}</span></div>
                      <div class="font-mono text-[11px] text-text-muted">Θ <span class="text-loss">{{ p.theta }}</span></div>
                    </td>
                    <td class="px-4 py-3.5">
                      <AppBadge :variant="statusConfig[p.status].variant" :label="statusConfig[p.status].label" />
                    </td>
                  </tr>
                </tbody>
              </table>
            </PanelCard>

            <!-- Trade history -->
            <PanelCard v-else>
              <template #header>Trade History</template>
              <template #actions>
                <AppBadge variant="green" :label="`${histWins}/${history.length} WINS`" />
              </template>
              <table class="w-full text-left">
                <thead>
                  <tr class="border-b border-border/60">
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Symbol</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Strategy</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Contract</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Entry</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Exit</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">P&L</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Journal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="h in history" :key="h.id"
                    class="border-b border-border/40 hover:bg-bg-elevated transition-colors duration-100 group cursor-pointer"
                  >
                    <td class="px-4 py-3.5">
                      <div class="font-mono text-sm font-bold text-text-primary group-hover:text-cyan transition-colors">{{ h.ticker }}</div>
                    </td>
                    <td class="px-4 py-3.5">
                      <span class="text-[11px] text-text-muted">{{ h.strategy }}</span>
                    </td>
                    <td class="px-4 py-3.5">
                      <span class="font-mono text-[11px] text-text-primary">{{ h.entry }}</span>
                    </td>
                    <td class="px-4 py-3.5">
                      <span class="font-mono text-[11px] text-text-ghost">{{ h.entryDate }}</span>
                    </td>
                    <td class="px-4 py-3.5">
                      <span class="font-mono text-[11px] text-text-ghost">{{ h.exitDate }}</span>
                    </td>
                    <td class="px-4 py-3.5">
                      <div :class="['font-mono text-[12px] font-bold', h.pnl >= 0 ? 'text-profit' : 'text-loss']">
                        {{ h.pnl >= 0 ? '+' : '' }}${{ Math.abs(h.pnl).toLocaleString() }}
                      </div>
                      <div :class="['font-mono text-[10px]', h.pctPnl >= 0 ? 'text-profit-dim' : 'text-loss-dim']">
                        {{ h.pctPnl >= 0 ? '+' : '' }}{{ h.pctPnl }}%
                      </div>
                    </td>
                    <td class="px-4 py-3.5">
                      <button
                        @click="router.push('/journal')"
                        class="flex items-center gap-1 font-mono text-[10px] text-text-ghost border border-border rounded px-2 py-1 hover:border-cyan/40 hover:text-cyan transition-all opacity-0 group-hover:opacity-100"
                      >
                        <BookOpen class="h-3 w-3" />
                        Journal
                      </button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </PanelCard>
          </div>

          <!-- Right: performance panel -->
          <div class="flex flex-col gap-3.5">

            <!-- P&L curve -->
            <PanelCard>
              <template #header>P&L Curve</template>
              <template #actions>
                <AppBadge variant="green" label="+$4,820" />
              </template>
              <div class="px-2 pt-1 pb-2">
                <svg :viewBox="`0 0 ${PW} ${PH}`" preserveAspectRatio="none" class="w-full" style="height: 100px">
                  <defs>
                    <linearGradient id="pnlGrad2" x1="0" y1="0" x2="0" y2="1">
                      <stop offset="0%"   stop-color="#00E676" stop-opacity="0.25" />
                      <stop offset="100%" stop-color="#00E676" stop-opacity="0" />
                    </linearGradient>
                  </defs>
                  <line x1="0" y1="33" x2="340" y2="33" stroke="#1A2640" stroke-width="0.5" stroke-dasharray="2 4" />
                  <line x1="0" y1="66" x2="340" y2="66" stroke="#1A2640" stroke-width="0.5" stroke-dasharray="2 4" />
                  <path :d="pnlFillPath" fill="url(#pnlGrad2)" />
                  <path :d="pnlLinePath" fill="none" stroke="#00D4FF" stroke-width="1.5" />
                  <!-- Current value dot -->
                  <circle
                    :cx="PW" :cy="PH - 8 - ((pnlCurve[pnlCurve.length-1] - pnlMin) / pnlRng) * (PH - 16)"
                    r="3" fill="#00D4FF"
                  />
                </svg>
              </div>
            </PanelCard>

            <!-- Win rate donut -->
            <div class="bg-bg-surface border border-border rounded-card p-4">
              <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost mb-4">Win Rate</p>
              <div class="flex items-center gap-4">
                <svg width="80" height="80" viewBox="0 0 80 80">
                  <!-- Track -->
                  <circle cx="40" cy="40" :r="DONUT_R" fill="none" stroke="#1A2640" stroke-width="8" />
                  <!-- Arc -->
                  <circle
                    cx="40" cy="40" :r="DONUT_R"
                    fill="none" stroke="#00E676" stroke-width="8"
                    stroke-linecap="round"
                    :stroke-dasharray="`${donutArc} ${DONUT_CIRC}`"
                    transform="rotate(-90 40 40)"
                  />
                  <text x="40" y="44" text-anchor="middle" font-family="monospace" font-size="13" font-weight="bold" fill="#00E676">
                    {{ winRate }}%
                  </text>
                </svg>
                <div class="space-y-2">
                  <div>
                    <p class="font-mono text-[9px] text-text-ghost uppercase tracking-wider">Wins</p>
                    <p class="font-mono text-[14px] font-bold text-profit">{{ histWins }}</p>
                  </div>
                  <div>
                    <p class="font-mono text-[9px] text-text-ghost uppercase tracking-wider">Losses</p>
                    <p class="font-mono text-[14px] font-bold text-loss">{{ history.length - histWins }}</p>
                  </div>
                </div>
              </div>
            </div>

            <!-- Risk overview -->
            <div class="bg-bg-surface border border-border rounded-card p-4 space-y-3">
              <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Risk Overview</p>
              <div class="space-y-2.5">
                <div v-for="row in [
                  { label: 'Avg Win',    value: '+$1,076', color: 'text-profit' },
                  { label: 'Avg Loss',   value: '-$180',   color: 'text-loss' },
                  { label: 'Best Trade', value: '+$2,100', color: 'text-profit' },
                  { label: 'Worst',      value: '-$240',   color: 'text-loss' },
                  { label: 'Avg Hold',   value: '9.5 days', color: 'text-text-primary' },
                ]" :key="row.label" class="flex justify-between items-center">
                  <span class="font-mono text-[10px] text-text-ghost">{{ row.label }}</span>
                  <span :class="['font-mono text-[11px] font-semibold', row.color]">{{ row.value }}</span>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
</template>
