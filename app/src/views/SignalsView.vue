<script setup>
import { ref, computed } from 'vue'
import MetricCard from '../components/ui/MetricCard.vue'
import PanelCard from '../components/ui/PanelCard.vue'
import AppBadge from '../components/ui/AppBadge.vue'
import ScoreBar from '../components/ui/ScoreBar.vue'
import {
  TrendingUp, TrendingDown, Minus,
  SlidersHorizontal, ChevronDown, Circle,
  Zap, Activity, CheckCircle, XCircle, Clock
} from 'lucide-vue-next'

// ── Filters ────────────────────────────────────────────────────
const filterDate      = ref('today')
const filterSetup     = ref('all')
const filterDirection = ref('all')
const filterStatus    = ref('all')

const dateOptions  = ['today', '7d', '30d', 'all']
const setupOptions = [
  { id: 'all',       label: 'All Setups' },
  { id: 'iv-crush',  label: 'IV Crush Play' },
  { id: 'momentum',  label: 'Momentum Breakout' },
  { id: 'mean-rev',  label: 'Mean Reversion' },
  { id: 'earnings',  label: 'Earnings Play' },
]
const directions = ['all', 'bull', 'bear', 'neutral']
const statuses   = ['all', 'new', 'reviewed', 'actioned', 'dismissed', 'expired']

// ── Signal data (mock) ─────────────────────────────────────────
const allSignals = [
  {
    id: 1, ts: '14:32:07', ticker: 'TSLA', contract: '$250C Apr 18',
    setup: 'IV Crush Play', direction: 'neutral',
    features: ['IV Spike', 'Volume Surge', 'OI Delta'],
    score: 91, status: 'new', watchlist: 'High IV Targets',
  },
  {
    id: 2, ts: '13:15:44', ticker: 'NVDA', contract: '$880C Apr 4',
    setup: 'Momentum Breakout', direction: 'bull',
    features: ['RSI Cross', 'Volume Surge'],
    score: 84, status: 'actioned', watchlist: 'Tech Plays',
  },
  {
    id: 3, ts: '12:48:22', ticker: 'AAPL', contract: '$190P Mar 28',
    setup: 'Mean Reversion', direction: 'bear',
    features: ['Overbought RSI', 'Resistance Level'],
    score: 79, status: 'reviewed', watchlist: 'Tech Plays',
  },
  {
    id: 4, ts: '11:30:09', ticker: 'AMD', contract: '$175C Apr 11',
    setup: 'Momentum Breakout', direction: 'bull',
    features: ['RSI Cross', 'Price Action'],
    score: 76, status: 'actioned', watchlist: 'Tech Plays',
  },
  {
    id: 5, ts: '10:55:33', ticker: 'META', contract: '$480C Apr 18',
    setup: 'Earnings Play', direction: 'bull',
    features: ['Earnings Proximity', 'IV Expansion'],
    score: 72, status: 'new', watchlist: 'Earnings Watch',
  },
  {
    id: 6, ts: '10:02:17', ticker: 'SPY', contract: '$540P Mar 21',
    setup: 'Mean Reversion', direction: 'bear',
    features: ['Overbought RSI', 'IV Percentile'],
    score: 67, status: 'dismissed', watchlist: 'High IV Targets',
  },
  {
    id: 7, ts: '09:44:58', ticker: 'MSTR', contract: '$180P Mar 28',
    setup: 'IV Crush Play', direction: 'bear',
    features: ['IV Spike', 'OI Delta'],
    score: 61, status: 'expired', watchlist: 'High IV Targets',
  },
  {
    id: 8, ts: '09:18:03', ticker: 'PLTR', contract: '$26C Apr 11',
    setup: 'Momentum Breakout', direction: 'neutral',
    features: ['Volume Surge', 'Price Action'],
    score: 58, status: 'expired', watchlist: 'Tech Plays',
  },
]

// ── Filtered signals ───────────────────────────────────────────
const signals = computed(() => {
  return allSignals.filter(s => {
    if (filterDirection.value !== 'all' && s.direction !== filterDirection.value) return false
    if (filterStatus.value !== 'all' && s.status !== filterStatus.value) return false
    if (filterSetup.value !== 'all') {
      const label = setupOptions.find(o => o.id === filterSetup.value)?.label
      if (s.setup !== label) return false
    }
    return true
  })
})

// ── Metrics ────────────────────────────────────────────────────
const metrics = [
  { label: 'Signals Today',  value: '47',  change: '+12 vs yesterday', changeType: 'up',      accent: 'cyan' },
  { label: 'High Score >80', value: '12',  change: '25.5% of total',   changeType: 'neutral', accent: 'violet' },
  { label: 'Actioned',       value: '8',   change: '17% action rate',  changeType: 'up',      accent: 'profit' },
  { label: 'Expired',        value: '6',   change: '3 dismissed',      changeType: 'neutral', accent: 'warn' },
]

// ── Setup distribution (sidebar) ──────────────────────────────
const setupDist = computed(() => {
  const counts = {}
  allSignals.forEach(s => { counts[s.setup] = (counts[s.setup] || 0) + 1 })
  return Object.entries(counts)
    .map(([name, count]) => ({ name, count }))
    .sort((a, b) => b.count - a.count)
})

// ── Status config ──────────────────────────────────────────────
const statusConfig = {
  new:       { label: 'New',       variant: 'cyan',   icon: Circle },
  reviewed:  { label: 'Reviewed',  variant: 'violet', icon: Clock },
  actioned:  { label: 'Actioned',  variant: 'green',  icon: CheckCircle },
  dismissed: { label: 'Dismissed', variant: 'amber',  icon: XCircle },
  expired:   { label: 'Expired',   variant: 'amber',  icon: XCircle },
}

const directionConfig = {
  bull:    { label: 'Bull',    color: 'text-profit', icon: TrendingUp },
  bear:    { label: 'Bear',    color: 'text-loss',   icon: TrendingDown },
  neutral: { label: 'Neutral', color: 'text-warn',   icon: Minus },
}

// inline action on a signal (mock — just mutates status)
const markActioned  = (s) => { s.status = 'actioned' }
const markDismissed = (s) => { s.status = 'dismissed' }
</script>

<template>
  <div class="flex flex-col gap-3.5 p-4 bg-bg-base min-h-screen">

        <!-- ── Metrics ────────────────────────────────────────── -->
        <div class="grid grid-cols-4 gap-2.5">
          <MetricCard v-for="m in metrics" :key="m.label" v-bind="m" />
        </div>

        <!-- ── Filter bar ──────────────────────────────────────── -->
        <div class="flex items-center gap-2.5 bg-bg-surface border border-border rounded-card px-4 py-3">
          <SlidersHorizontal class="h-4 w-4 text-text-ghost shrink-0" />

          <!-- Date range -->
          <div class="flex items-center bg-bg-elevated border border-border rounded-chip overflow-hidden">
            <button
              v-for="d in dateOptions" :key="d"
              @click="filterDate = d"
              :class="[
                'px-3 py-1.5 font-mono text-[11px] uppercase transition-all duration-150',
                filterDate === d ? 'bg-cyan/15 text-cyan' : 'text-text-ghost hover:text-text-primary'
              ]"
            >{{ d }}</button>
          </div>

          <!-- Setup -->
          <div class="relative">
            <select v-model="filterSetup"
              class="appearance-none bg-bg-elevated border border-border rounded-chip pl-3 pr-8 py-1.5 font-mono text-[11px] text-text-primary outline-none focus:border-cyan/40 transition-colors cursor-pointer">
              <option v-for="s in setupOptions" :key="s.id" :value="s.id">{{ s.label }}</option>
            </select>
            <ChevronDown class="h-3 w-3 text-text-ghost absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" />
          </div>

          <!-- Direction -->
          <div class="flex items-center bg-bg-elevated border border-border rounded-chip overflow-hidden">
            <button
              v-for="d in directions" :key="d"
              @click="filterDirection = d"
              :class="[
                'px-3 py-1.5 font-mono text-[11px] capitalize transition-all duration-150',
                filterDirection === d ? 'bg-cyan/15 text-cyan' : 'text-text-ghost hover:text-text-primary'
              ]"
            >{{ d }}</button>
          </div>

          <!-- Status -->
          <div class="relative">
            <select v-model="filterStatus"
              class="appearance-none bg-bg-elevated border border-border rounded-chip pl-3 pr-8 py-1.5 font-mono text-[11px] text-text-primary outline-none focus:border-cyan/40 transition-colors cursor-pointer capitalize">
              <option v-for="s in statuses" :key="s" :value="s" class="capitalize">{{ s === 'all' ? 'All Statuses' : s }}</option>
            </select>
            <ChevronDown class="h-3 w-3 text-text-ghost absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" />
          </div>

          <div class="flex-1" />
          <AppBadge variant="cyan" :label="`${signals.length} SIGNALS`" />
        </div>

        <!-- ── Main layout ─────────────────────────────────────── -->
        <div class="grid grid-cols-[1fr_220px] gap-3.5">

          <!-- Feed table -->
          <PanelCard>
            <template #header>
              <div class="flex items-center gap-2">
                <Activity class="h-3.5 w-3.5 text-cyan" />
                <span>Signal Feed</span>
              </div>
            </template>
            <template #actions>
              <div class="flex items-center gap-1.5">
                <span class="h-1.5 w-1.5 rounded-full bg-profit animate-pulse" />
                <span class="font-mono text-[10px] text-profit">Live</span>
              </div>
            </template>

            <table class="w-full text-left">
              <thead>
                <tr class="border-b border-border/60">
                  <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Time</th>
                  <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Symbol</th>
                  <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Setup</th>
                  <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Dir</th>
                  <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost min-w-[120px]">Score</th>
                  <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Status</th>
                  <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost text-right">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr
                  v-for="sig in signals" :key="sig.id"
                  class="border-b border-border/40 hover:bg-bg-elevated transition-colors duration-100 group"
                >
                  <!-- Time -->
                  <td class="px-4 py-3">
                    <span class="font-mono text-[10px] text-text-ghost">{{ sig.ts }}</span>
                  </td>

                  <!-- Symbol -->
                  <td class="px-4 py-3">
                    <div class="font-mono text-sm font-bold text-text-primary group-hover:text-cyan transition-colors">{{ sig.ticker }}</div>
                    <div class="font-mono text-[10px] text-text-ghost">{{ sig.contract }}</div>
                  </td>

                  <!-- Setup -->
                  <td class="px-4 py-3">
                    <div class="text-[11px] font-medium text-text-primary mb-1">{{ sig.setup }}</div>
                    <div class="flex flex-wrap gap-1">
                      <span
                        v-for="f in sig.features" :key="f"
                        class="font-mono text-[9px] border border-border rounded px-1.5 py-0.5 text-text-ghost"
                      >{{ f }}</span>
                    </div>
                  </td>

                  <!-- Direction -->
                  <td class="px-4 py-3">
                    <div class="flex items-center gap-1">
                      <component :is="directionConfig[sig.direction].icon" :class="['h-3.5 w-3.5', directionConfig[sig.direction].color]" />
                      <span :class="['font-mono text-[10px]', directionConfig[sig.direction].color]">
                        {{ directionConfig[sig.direction].label }}
                      </span>
                    </div>
                  </td>

                  <!-- Score -->
                  <td class="px-4 py-3">
                    <ScoreBar :score="sig.score" />
                  </td>

                  <!-- Status -->
                  <td class="px-4 py-3">
                    <AppBadge :variant="statusConfig[sig.status].variant" :label="statusConfig[sig.status].label" />
                  </td>

                  <!-- Actions -->
                  <td class="px-4 py-3 text-right">
                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                      <button
                        v-if="sig.status === 'new' || sig.status === 'reviewed'"
                        @click="markActioned(sig)"
                        class="font-mono text-[9px] text-profit border border-profit/30 rounded px-2 py-1 hover:bg-profit/10 transition-colors"
                      >Action</button>
                      <button
                        v-if="sig.status === 'new' || sig.status === 'reviewed'"
                        @click="markDismissed(sig)"
                        class="font-mono text-[9px] text-text-ghost border border-border rounded px-2 py-1 hover:border-border-strong transition-colors"
                      >Dismiss</button>
                    </div>
                  </td>
                </tr>

                <!-- Empty -->
                <tr v-if="signals.length === 0">
                  <td colspan="7" class="px-4 py-14 text-center">
                    <Zap class="h-7 w-7 text-text-ghost mx-auto mb-2" />
                    <p class="text-sm text-text-muted">No signals match the current filters.</p>
                  </td>
                </tr>
              </tbody>
            </table>
          </PanelCard>

          <!-- Right sidebar -->
          <div class="flex flex-col gap-3.5">

            <!-- Action rate -->
            <div class="bg-bg-surface border border-border rounded-card p-4 space-y-3">
              <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Today's Rate</p>
              <div class="space-y-2.5">
                <div v-for="row in [
                  { label: 'Generated', value: 47, color: 'bg-cyan' },
                  { label: 'Actioned',  value: 8,  color: 'bg-profit' },
                  { label: 'Dismissed', value: 3,  color: 'bg-warn' },
                  { label: 'Expired',   value: 6,  color: 'bg-text-ghost' },
                ]" :key="row.label" class="flex items-center gap-2">
                  <div class="flex-1 min-w-0">
                    <div class="font-mono text-[10px] text-text-muted mb-1">{{ row.label }}</div>
                    <div class="h-1 bg-bg-hover rounded-full overflow-hidden">
                      <div :class="['h-full rounded-full', row.color]" :style="{ width: `${(row.value / 47) * 100}%` }" />
                    </div>
                  </div>
                  <span class="font-mono text-[11px] font-bold text-text-primary w-5 text-right shrink-0">{{ row.value }}</span>
                </div>
              </div>
            </div>

            <!-- Setup distribution -->
            <PanelCard>
              <template #header>
                <div class="flex items-center gap-2">
                  <Zap class="h-3.5 w-3.5 text-text-ghost" />
                  <span>By Setup</span>
                </div>
              </template>
              <div class="p-3 space-y-2">
                <div v-for="s in setupDist" :key="s.name" class="flex items-center gap-2">
                  <div class="h-1.5 w-1.5 rounded-full bg-cyan shrink-0" />
                  <span class="font-mono text-[10px] text-text-muted flex-1 truncate">{{ s.name }}</span>
                  <span class="font-mono text-[11px] font-bold text-text-primary">{{ s.count }}</span>
                </div>
              </div>
            </PanelCard>

            <!-- Signal lifecycle legend -->
            <div class="bg-bg-surface border border-border rounded-card p-4 space-y-2">
              <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost mb-3">Lifecycle</p>
              <div v-for="(cfg, key) in statusConfig" :key="key" class="flex items-center gap-2">
                <component :is="cfg.icon" class="h-3 w-3 text-text-ghost shrink-0" />
                <span class="font-mono text-[10px] text-text-muted capitalize">{{ cfg.label }}</span>
              </div>
            </div>

          </div>
        </div>
      </div>
</template>
