<script setup>
import { ref, computed, onMounted } from 'vue'
import MetricCard from '../components/ui/MetricCard.vue'
import PanelCard from '../components/ui/PanelCard.vue'
import AppBadge from '../components/ui/AppBadge.vue'
import ScoreBar from '../components/ui/ScoreBar.vue'
import { useWatchlistStore } from '@/modules/watchlists/stores/useWatchlistStore'
import {
  RefreshCw, SlidersHorizontal, ChevronDown,
  TrendingUp, TrendingDown, Minus, Clock,
  Layers, Zap, Activity, Target
} from 'lucide-vue-next'

const watchlistStore = useWatchlistStore()

onMounted(() => {
  watchlistStore.fetchWatchlists()
})

// ── Filter state ───────────────────────────────────────────────
const selectedWatchlist = ref('all')
const selectedSetup     = ref('all')
const selectedDirection = ref('all')
const minScore          = ref(0)
const scanning          = ref(false)
const lastScanned       = ref('14:32:07')

const watchlists = computed(() => [
  { id: 'all', label: 'All Watchlists' },
  ...watchlistStore.watchlists.map(wl => ({ id: String(wl.id), label: wl.name })),
])

const setups = [
  { id: 'all',        label: 'All Setups' },
  { id: 'iv-crush',   label: 'IV Crush Play' },
  { id: 'momentum',   label: 'Momentum Breakout' },
  { id: 'mean-rev',   label: 'Mean Reversion' },
  { id: 'earnings',   label: 'Earnings Play' },
]

const directions = [
  { id: 'all',  label: 'All' },
  { id: 'bull', label: 'Bull' },
  { id: 'bear', label: 'Bear' },
  { id: 'neutral', label: 'Neutral' },
]

const scoreThresholds = [
  { id: 0,  label: 'Any Score' },
  { id: 60, label: '60+' },
  { id: 70, label: '70+' },
  { id: 80, label: '80+' },
  { id: 90, label: '90+' },
]

// ── Mock results ───────────────────────────────────────────────
const allResults = [
  {
    id: 1, ticker: 'TSLA', exchange: 'NASDAQ',
    contract: '$250C', expiry: 'Apr 18', type: 'Call',
    iv: 94.2, ivRank: 87, score: 91,
    direction: 'bull', setup: 'IV Crush Play',
    delta: 0.42, theta: -0.18,
    volume: '12.4K', oi: '48.2K',
    watchlist: 'High IV Targets',
    features: ['IV Spike', 'Volume Surge', 'OI Delta'],
  },
  {
    id: 2, ticker: 'NVDA', exchange: 'NASDAQ',
    contract: '$880C', expiry: 'Apr 4', type: 'Call',
    iv: 78.1, ivRank: 72, score: 84,
    direction: 'bull', setup: 'Momentum Breakout',
    delta: 0.38, theta: -0.22,
    volume: '8.7K', oi: '31.5K',
    watchlist: 'Tech Plays',
    features: ['RSI Cross', 'Price Action', 'Volume Surge'],
  },
  {
    id: 3, ticker: 'AAPL', exchange: 'NASDAQ',
    contract: '$190P', expiry: 'Mar 28', type: 'Put',
    iv: 65.8, ivRank: 61, score: 79,
    direction: 'bear', setup: 'Mean Reversion',
    delta: -0.35, theta: -0.14,
    volume: '5.2K', oi: '22.1K',
    watchlist: 'Tech Plays',
    features: ['Overbought RSI', 'Resistance Level', 'IV Percentile'],
  },
  {
    id: 4, ticker: 'AMD', exchange: 'NASDAQ',
    contract: '$175C', expiry: 'Apr 11', type: 'Call',
    iv: 81.3, ivRank: 74, score: 76,
    direction: 'bull', setup: 'Momentum Breakout',
    delta: 0.30, theta: -0.19,
    volume: '6.9K', oi: '18.7K',
    watchlist: 'Tech Plays',
    features: ['Volume Surge', 'Price Action'],
  },
  {
    id: 5, ticker: 'META', exchange: 'NASDAQ',
    contract: '$480C', expiry: 'Apr 18', type: 'Call',
    iv: 71.4, ivRank: 68, score: 72,
    direction: 'bull', setup: 'Earnings Play',
    delta: 0.28, theta: -0.31,
    volume: '3.1K', oi: '14.8K',
    watchlist: 'Earnings Watch',
    features: ['Earnings Proximity', 'IV Expansion'],
  },
  {
    id: 6, ticker: 'SPY', exchange: 'NYSE',
    contract: '$540P', expiry: 'Mar 21', type: 'Put',
    iv: 48.2, ivRank: 55, score: 67,
    direction: 'bear', setup: 'Mean Reversion',
    delta: -0.24, theta: -0.09,
    volume: '28.4K', oi: '142.6K',
    watchlist: 'High IV Targets',
    features: ['Overbought RSI', 'IV Percentile'],
  },
  {
    id: 7, ticker: 'MSTR', exchange: 'NASDAQ',
    contract: '$180P', expiry: 'Mar 28', type: 'Put',
    iv: 88.4, ivRank: 82, score: 61,
    direction: 'bear', setup: 'IV Crush Play',
    delta: -0.33, theta: -0.27,
    volume: '4.4K', oi: '9.3K',
    watchlist: 'High IV Targets',
    features: ['IV Spike', 'OI Delta'],
  },
  {
    id: 8, ticker: 'PLTR', exchange: 'NYSE',
    contract: '$26C', expiry: 'Apr 11', type: 'Call',
    iv: 79.6, ivRank: 70, score: 58,
    direction: 'neutral', setup: 'Momentum Breakout',
    delta: 0.39, theta: -0.16,
    volume: '7.2K', oi: '33.4K',
    watchlist: 'Tech Plays',
    features: ['Volume Surge', 'Price Action'],
  },
]

// ── Filtered results ───────────────────────────────────────────
const filteredResults = computed(() => {
  return allResults.filter(r => {
    if (selectedDirection.value !== 'all' && r.direction !== selectedDirection.value) return false
    if (selectedSetup.value !== 'all' && r.setup !== setups.find(s => s.id === selectedSetup.value)?.label) return false
    if (r.score < minScore.value) return false
    return true
  })
})

// ── Metrics ────────────────────────────────────────────────────
const metrics = computed(() => [
  { label: 'Symbols Scanned', value: '147',    change: 'from 3 watchlists', changeType: 'neutral', accent: 'cyan' },
  { label: 'Contracts Analyzed', value: '18,432', change: '+2.1K vs last run', changeType: 'up', accent: 'violet' },
  { label: 'Setups Matched', value: filteredResults.value.length.toString(), change: `${allResults.filter(r => r.score >= 80).length} high score`, changeType: 'up', accent: 'profit' },
  { label: 'Avg Score', value: Math.round(filteredResults.value.reduce((a, r) => a + r.score, 0) / (filteredResults.value.length || 1)).toString(), change: 'across matched setups', changeType: 'neutral', accent: 'warn' },
])

// ── Setup distribution (for sidebar) ──────────────────────────
const setupDistribution = computed(() => {
  const counts = {}
  allResults.forEach(r => { counts[r.setup] = (counts[r.setup] || 0) + 1 })
  return Object.entries(counts).map(([name, count]) => ({ name, count })).sort((a, b) => b.count - a.count)
})

const watchlistDistribution = computed(() => {
  const counts = {}
  allResults.forEach(r => { counts[r.watchlist] = (counts[r.watchlist] || 0) + 1 })
  return Object.entries(counts).map(([name, count]) => ({ name, count })).sort((a, b) => b.count - a.count)
})

// ── Helpers ────────────────────────────────────────────────────
const directionConfig = {
  bull:    { label: 'Bull',    color: 'text-profit', bg: 'bg-profit/10 border-profit/20', icon: TrendingUp },
  bear:    { label: 'Bear',    color: 'text-loss',   bg: 'bg-loss/10 border-loss/20',     icon: TrendingDown },
  neutral: { label: 'Neutral', color: 'text-warn',   bg: 'bg-warn/10 border-warn/20',     icon: Minus },
}

const ivRankColor = (rank) => {
  if (rank >= 80) return 'text-loss'
  if (rank >= 60) return 'text-warn'
  return 'text-profit'
}

const setupBadgeVariant = (setup) => {
  const map = {
    'IV Crush Play':      'red',
    'Momentum Breakout':  'cyan',
    'Mean Reversion':     'violet',
    'Earnings Play':      'amber',
  }
  return map[setup] || 'cyan'
}

const runScan = () => {
  scanning.value = true
  setTimeout(() => {
    scanning.value = false
    lastScanned.value = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', second: '2-digit' })
  }, 1800)
}
</script>

<template>
  <div class="flex flex-col gap-3.5 p-4 bg-bg-base min-h-screen">

        <!-- ── Metrics row ─────────────────────────────────────── -->
        <div class="grid grid-cols-4 gap-2.5">
          <MetricCard v-for="m in metrics" :key="m.label" v-bind="m" />
        </div>

        <!-- ── Filter bar ──────────────────────────────────────── -->
        <div class="flex items-center gap-2.5 bg-bg-surface border border-border rounded-card px-4 py-3">
          <SlidersHorizontal class="h-4 w-4 text-text-ghost shrink-0" />

          <!-- Watchlist -->
          <div class="relative">
            <select
              v-model="selectedWatchlist"
              class="appearance-none bg-bg-elevated border border-border rounded-chip pl-3 pr-8 py-1.5 font-mono text-[11px] text-text-primary cursor-pointer outline-none hover:border-border-strong focus:border-cyan/40 transition-colors"
            >
              <option v-for="w in watchlists" :key="w.id" :value="w.id">{{ w.label }}</option>
            </select>
            <ChevronDown class="h-3 w-3 text-text-ghost absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" />
          </div>

          <!-- Setup -->
          <div class="relative">
            <select
              v-model="selectedSetup"
              class="appearance-none bg-bg-elevated border border-border rounded-chip pl-3 pr-8 py-1.5 font-mono text-[11px] text-text-primary cursor-pointer outline-none hover:border-border-strong focus:border-cyan/40 transition-colors"
            >
              <option v-for="s in setups" :key="s.id" :value="s.id">{{ s.label }}</option>
            </select>
            <ChevronDown class="h-3 w-3 text-text-ghost absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" />
          </div>

          <!-- Direction toggle -->
          <div class="flex items-center bg-bg-elevated border border-border rounded-chip overflow-hidden">
            <button
              v-for="d in directions"
              :key="d.id"
              @click="selectedDirection = d.id"
              :class="[
                'px-3 py-1.5 font-mono text-[11px] transition-all duration-150',
                selectedDirection === d.id
                  ? 'bg-cyan/15 text-cyan'
                  : 'text-text-ghost hover:text-text-primary'
              ]"
            >
              {{ d.label }}
            </button>
          </div>

          <!-- Min score -->
          <div class="relative">
            <select
              v-model="minScore"
              class="appearance-none bg-bg-elevated border border-border rounded-chip pl-3 pr-8 py-1.5 font-mono text-[11px] text-text-primary cursor-pointer outline-none hover:border-border-strong focus:border-cyan/40 transition-colors"
            >
              <option v-for="t in scoreThresholds" :key="t.id" :value="t.id">{{ t.label }}</option>
            </select>
            <ChevronDown class="h-3 w-3 text-text-ghost absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none" />
          </div>

          <!-- Spacer -->
          <div class="flex-1" />

          <!-- Last scan time -->
          <div class="flex items-center gap-1.5 font-mono text-[10px] text-text-ghost">
            <Clock class="h-3 w-3" />
            {{ lastScanned }}
          </div>

          <!-- Scan button -->
          <button
            @click="runScan"
            :disabled="scanning"
            class="flex items-center gap-2 bg-cyan text-bg-base px-4 py-1.5 rounded-chip font-mono text-[11px] font-bold uppercase tracking-[0.15em] hover:bg-cyan-dim transition-colors disabled:opacity-60 disabled:cursor-not-allowed"
          >
            <RefreshCw :class="['h-3.5 w-3.5', scanning && 'animate-spin']" />
            {{ scanning ? 'Scanning...' : 'Run Scan' }}
          </button>
        </div>

        <!-- ── Main area ────────────────────────────────────────── -->
        <div class="grid grid-cols-[1fr_260px] gap-3.5">

          <!-- Results table -->
          <PanelCard>
            <template #header>
              <div class="flex items-center gap-2">
                <Activity class="h-3.5 w-3.5 text-cyan" />
                <span>Scanner Results</span>
              </div>
            </template>
            <template #actions>
              <AppBadge variant="cyan" :label="`${filteredResults.length} MATCHES`" />
            </template>

            <!-- Table -->
            <div class="overflow-x-auto">
              <table class="w-full text-left">
                <thead>
                  <tr class="border-b border-border/60">
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost w-8">#</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Symbol</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Contract</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Setup</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Direction</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">IV / Rank</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Greeks</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Vol / OI</th>
                    <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost min-w-[130px]">Score</th>
                  </tr>
                </thead>

                <tbody>
                  <tr
                    v-for="(result, i) in filteredResults"
                    :key="result.id"
                    class="border-b border-border/40 hover:bg-bg-elevated transition-colors duration-100 group cursor-pointer"
                  >
                    <!-- Rank -->
                    <td class="px-4 py-3.5">
                      <span class="font-mono text-[10px] text-text-ghost">{{ i + 1 }}</span>
                    </td>

                    <!-- Symbol -->
                    <td class="px-4 py-3.5">
                      <div class="font-mono text-sm font-bold text-text-primary group-hover:text-cyan transition-colors">
                        {{ result.ticker }}
                      </div>
                      <div class="font-mono text-[10px] text-text-ghost">{{ result.exchange }} · {{ result.watchlist }}</div>
                    </td>

                    <!-- Contract -->
                    <td class="px-4 py-3.5">
                      <div class="font-mono text-xs font-semibold text-text-primary">{{ result.contract }}</div>
                      <div class="font-mono text-[10px] text-text-ghost">{{ result.expiry }} · {{ result.type }}</div>
                    </td>

                    <!-- Setup -->
                    <td class="px-4 py-3.5">
                      <AppBadge :variant="setupBadgeVariant(result.setup)" :label="result.setup" />
                      <div class="mt-1.5 flex flex-wrap gap-1">
                        <span
                          v-for="f in result.features"
                          :key="f"
                          class="font-mono text-[9px] text-text-ghost border border-border rounded px-1.5 py-0.5"
                        >
                          {{ f }}
                        </span>
                      </div>
                    </td>

                    <!-- Direction -->
                    <td class="px-4 py-3.5">
                      <div :class="['inline-flex items-center gap-1.5 border rounded-chip px-2 py-1', directionConfig[result.direction].bg]">
                        <component :is="directionConfig[result.direction].icon" :class="['h-3 w-3', directionConfig[result.direction].color]" />
                        <span :class="['font-mono text-[10px] font-bold', directionConfig[result.direction].color]">
                          {{ directionConfig[result.direction].label }}
                        </span>
                      </div>
                    </td>

                    <!-- IV / Rank -->
                    <td class="px-4 py-3.5">
                      <div class="font-mono text-xs text-text-primary">{{ result.iv }}%</div>
                      <div :class="['font-mono text-[10px] font-bold', ivRankColor(result.ivRank)]">
                        Rank {{ result.ivRank }}
                      </div>
                    </td>

                    <!-- Greeks -->
                    <td class="px-4 py-3.5">
                      <div class="font-mono text-[11px] text-text-muted">
                        Δ <span class="text-text-primary">{{ result.delta }}</span>
                      </div>
                      <div class="font-mono text-[11px] text-text-muted">
                        Θ <span class="text-loss">{{ result.theta }}</span>
                      </div>
                    </td>

                    <!-- Volume / OI -->
                    <td class="px-4 py-3.5">
                      <div class="font-mono text-[11px] text-text-primary">{{ result.volume }}</div>
                      <div class="font-mono text-[10px] text-text-ghost">OI {{ result.oi }}</div>
                    </td>

                    <!-- Score -->
                    <td class="px-4 py-3.5">
                      <ScoreBar :score="result.score" />
                    </td>
                  </tr>

                  <!-- Empty state -->
                  <tr v-if="filteredResults.length === 0">
                    <td colspan="9" class="px-4 py-16 text-center">
                      <div class="flex flex-col items-center gap-3">
                        <Target class="h-8 w-8 text-text-ghost" />
                        <p class="text-sm text-text-muted">No setups matched the current filters.</p>
                        <button
                          @click="selectedDirection = 'all'; selectedSetup = 'all'; minScore = 0"
                          class="font-mono text-[10px] text-cyan hover:text-cyan-dim transition-colors"
                        >
                          Clear filters
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </PanelCard>

          <!-- ── Right sidebar ──────────────────────────────────── -->
          <div class="flex flex-col gap-3.5">

            <!-- Scan status -->
            <div class="bg-bg-surface border border-border rounded-card p-4 space-y-3">
              <div class="flex items-center justify-between">
                <span class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Scan Status</span>
                <div class="flex items-center gap-1.5">
                  <span :class="['h-1.5 w-1.5 rounded-full', scanning ? 'bg-warn animate-pulse' : 'bg-profit animate-pulse']" />
                  <span :class="['font-mono text-[10px] font-bold', scanning ? 'text-warn' : 'text-profit']">
                    {{ scanning ? 'Running' : 'Idle' }}
                  </span>
                </div>
              </div>

              <div class="space-y-2.5 pt-1">
                <div class="flex justify-between items-center">
                  <span class="font-mono text-[10px] text-text-ghost">Mode</span>
                  <AppBadge variant="violet" label="MOCK" />
                </div>
                <div class="flex justify-between items-center">
                  <span class="font-mono text-[10px] text-text-ghost">Symbols</span>
                  <span class="font-mono text-[11px] text-text-primary">147</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="font-mono text-[10px] text-text-ghost">Contracts</span>
                  <span class="font-mono text-[11px] text-text-primary">18,432</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="font-mono text-[10px] text-text-ghost">Last run</span>
                  <span class="font-mono text-[11px] text-cyan">{{ lastScanned }}</span>
                </div>
              </div>
            </div>

            <!-- Watchlist breakdown -->
            <PanelCard>
              <template #header>
                <div class="flex items-center gap-2">
                  <Layers class="h-3.5 w-3.5 text-text-ghost" />
                  <span>Watchlists</span>
                </div>
              </template>

              <div class="p-3 space-y-2">
                <div
                  v-for="wl in watchlistDistribution"
                  :key="wl.name"
                  class="flex items-center gap-2"
                >
                  <div class="flex-1 min-w-0">
                    <div class="font-mono text-[10px] text-text-muted truncate">{{ wl.name }}</div>
                    <div class="mt-1 h-1 bg-bg-hover rounded-full overflow-hidden">
                      <div
                        class="h-full bg-cyan/50 rounded-full"
                        :style="{ width: `${(wl.count / allResults.length) * 100}%` }"
                      />
                    </div>
                  </div>
                  <span class="font-mono text-[11px] font-bold text-text-primary shrink-0">{{ wl.count }}</span>
                </div>
              </div>
            </PanelCard>

            <!-- Setup distribution -->
            <PanelCard>
              <template #header>
                <div class="flex items-center gap-2">
                  <Zap class="h-3.5 w-3.5 text-text-ghost" />
                  <span>Setups</span>
                </div>
              </template>

              <div class="p-3 space-y-2">
                <div
                  v-for="s in setupDistribution"
                  :key="s.name"
                  class="flex items-center justify-between gap-2"
                >
                  <div class="flex items-center gap-2 min-w-0">
                    <div class="h-1.5 w-1.5 rounded-full bg-cyan shrink-0" />
                    <span class="font-mono text-[10px] text-text-muted truncate">{{ s.name }}</span>
                  </div>
                  <span class="font-mono text-[11px] font-bold text-text-primary shrink-0">{{ s.count }}</span>
                </div>
              </div>
            </PanelCard>

            <!-- Info note -->
            <div class="bg-violet/5 border border-violet/20 rounded-card p-4 space-y-2">
              <div class="flex items-center gap-2">
                <div class="h-1.5 w-1.5 rounded-full bg-violet" />
                <span class="font-mono text-[10px] uppercase tracking-widest text-violet">Dev Note</span>
              </div>
              <p class="text-[11px] text-text-muted leading-relaxed">
                This view is a mock. The real scanner will evaluate <span class="text-text-primary">indicators</span> →
                <span class="text-text-primary">features</span> →
                <span class="text-text-primary">setups</span> against your watchlist symbols in real time.
              </p>
            </div>

          </div>
        </div>
      </div>
</template>
