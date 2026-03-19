<script setup>
import { ref, computed } from 'vue'
import AppBadge from '../components/ui/AppBadge.vue'
import ScoreBar from '../components/ui/ScoreBar.vue'
import {
  Plus, BookOpen, TrendingUp, TrendingDown, Minus,
  Sparkles, ChevronRight, Bot, Lightbulb
} from 'lucide-vue-next'

// ── Journal entries (mock) ─────────────────────────────────────
const entries = ref([
  {
    id: 1, date: 'Apr 5', ticker: 'TSLA', title: 'IV Crush before earnings',
    setup: 'IV Crush Play', direction: 'neutral', score: 91,
    status: 'analyzed', pnl: +840,
    contract: '$250C Apr 18', entryDate: 'Apr 5', exitDate: 'Apr 12',
    thesis: `IV Rank hit 87 on TSLA with earnings 8 days out. The IV Spike and Volume Surge features both triggered simultaneously, placing this squarely in IV Crush territory. My thesis is that IV will compress post-announcement regardless of direction, and the elevated volume suggests institutional positioning ahead of the event. Entered a call debit spread to reduce cost basis while capturing the vega compression.`,
    outcome: `IV compressed from 94.2% to ~71% by day 6, ahead of the actual earnings date. The spread captured $840 — close to max profit. Exited early at 85% of max to avoid gamma risk in the final week. The directional component (TSLA moved up ~4%) contributed a small additional delta gain that wasn't planned for.`,
    aiAnalysis: true,
  },
  {
    id: 2, date: 'Mar 25', ticker: 'NVDA', title: 'Momentum continuation after breakout',
    setup: 'Momentum Breakout', direction: 'bull', score: 84,
    status: 'complete', pnl: +1240,
    contract: '$880C Apr 4', entryDate: 'Mar 25', exitDate: 'Apr 1',
    thesis: `NVDA broke above the $870 resistance level with 2x average volume. RSI cross confirmed momentum. The setup score of 84 was strong — all three features aligned. Entered calls with 10 DTE to keep premium lean and maximize leverage on the move.`,
    outcome: `NVDA ran to $912 over the following week before pulling back. Closed at $876.40 on the position for +$1,240. The move was faster than expected — could have sized up given the clean setup.`,
    aiAnalysis: false,
  },
  {
    id: 3, date: 'Mar 19', ticker: 'SPY', title: 'Put hedge on market reversal signal',
    setup: 'Mean Reversion', direction: 'bear', score: 61,
    status: 'analyzed', pnl: +320,
    contract: '$540P Mar 21', entryDate: 'Mar 19', exitDate: 'Mar 20',
    thesis: `SPY overbought on RSI (72), and IV Percentile suggested hedging was cheap. Low conviction setup — score only 61. Used as a portfolio hedge rather than a directional trade.`,
    outcome: `SPY pulled back 0.8% the next session. Small gain on puts. Closed same day. Low risk, low reward as expected.`,
    aiAnalysis: false,
  },
  {
    id: 4, date: 'Mar 15', ticker: 'AAPL', title: 'Straddle ahead of CPI data',
    setup: 'Earnings Play', direction: 'neutral', score: 72,
    status: 'complete', pnl: -180,
    contract: '$190 Straddle Mar 28', entryDate: 'Mar 15', exitDate: 'Mar 22',
    thesis: `CPI data due in 5 days. Expected a volatility spike regardless of direction. IV was elevated but not extreme at 65.8%. Score of 72 was decent for the setup type.`,
    outcome: `CPI came in inline with expectations. No volatility spike. IV actually compressed slightly. Straddle lost value on both legs. Exited at -$180 to stop the theta bleed.`,
    aiAnalysis: false,
  },
  {
    id: 5, date: 'Mar 8', ticker: 'META', title: 'Failed mean reversion attempt',
    setup: 'Mean Reversion', direction: 'bear', score: 58,
    status: 'draft', pnl: null,
    contract: '$460P Mar 21', entryDate: 'Mar 8', exitDate: null,
    thesis: `META had been running for 3 weeks straight. RSI was 74, showing overbought. Setup score was only 58 — below my usual threshold but I took it anyway.`,
    outcome: null,
    aiAnalysis: false,
  },
])

const selectedId    = ref(1)
const selected      = computed(() => entries.value.find(e => e.id === selectedId.value))
const aiLoading     = ref(false)
const aiGenerated   = ref({ 1: true }) // entry id 1 already has AI analysis shown

const generateAnalysis = async () => {
  aiLoading.value = true
  // In production: call Claude API with trade context
  await new Promise(r => setTimeout(r, 1800))
  aiLoading.value = false
  aiGenerated.value[selectedId.value] = true
}

const showAI = computed(() => aiGenerated.value[selectedId.value])

// ── Mock AI response per entry ─────────────────────────────────
const aiResponses = {
  1: {
    summary: `This IV Crush Play on TSLA executed cleanly. The 87 IV Rank entry point was well-timed — you entered near the local IV peak, which is the core condition for this setup.`,
    insights: [
      `Both IV Spike and Volume Surge triggered simultaneously, giving strong setup confirmation. When all features align rather than just one, historical win rate on this setup is ~78% vs ~51% with partial confirmation.`,
      `Your delta was 0.42 at entry — slightly high for a pure vega play. A lower-strike spread or a ratio spread would have reduced directional exposure while preserving the IV crush capture. Something to tune for next TSLA IV Crush entry.`,
      `This is your 3rd IV Crush trade on TSLA in 90 days. Win rate on this specific combination is 2/3 (67%). The single losing trade had IV Rank of only 74 at entry — consider tightening your threshold to 80+ for TSLA specifically.`,
    ],
    recommendation: `For the next IV Crush entry on TSLA, target IV Rank ≥ 80, confirm with Volume Surge, and use a delta-neutral structure (e.g., debit spread centered near ATM) to reduce directional risk while maximizing vega capture.`,
  },
}

// ── Helpers ────────────────────────────────────────────────────
const statusConfig = {
  analyzed: { variant: 'cyan',   label: 'Analyzed' },
  complete: { variant: 'green',  label: 'Complete' },
  draft:    { variant: 'amber',  label: 'Draft' },
}

const directionConfig = {
  bull:    { label: 'Bull',    color: 'text-profit', icon: TrendingUp },
  bear:    { label: 'Bear',    color: 'text-loss',   icon: TrendingDown },
  neutral: { label: 'Neutral', color: 'text-warn',   icon: Minus },
}
</script>

<template>
  <div class="flex bg-bg-base min-h-screen">

        <!-- ── Left: entries list ───────────────────────────── -->
        <aside class="w-60 shrink-0 border-r border-border bg-bg-surface flex flex-col">

          <!-- Header -->
          <div class="flex items-center justify-between px-4 py-4 border-b border-border">
            <div class="flex items-center gap-2">
              <BookOpen class="h-4 w-4 text-cyan" />
              <span class="font-semibold text-sm text-text-primary">Journal</span>
            </div>
            <button class="h-7 w-7 rounded-chip bg-cyan/10 border border-cyan/20 flex items-center justify-center text-cyan hover:bg-cyan/20 transition-colors">
              <Plus class="h-3.5 w-3.5" />
            </button>
          </div>

          <!-- Entry list -->
          <div class="flex-1 overflow-auto py-2">
            <button
              v-for="entry in entries"
              :key="entry.id"
              @click="selectedId = entry.id"
              :class="[
                'w-full px-4 py-3.5 text-left transition-colors duration-100 border-l-2',
                selectedId === entry.id
                  ? 'bg-bg-hover border-l-cyan'
                  : 'hover:bg-bg-elevated border-l-transparent'
              ]"
            >
              <div class="flex items-center justify-between mb-1.5">
                <span :class="['font-mono text-[12px] font-bold', selectedId === entry.id ? 'text-cyan' : 'text-text-primary']">
                  {{ entry.ticker }}
                </span>
                <AppBadge :variant="statusConfig[entry.status].variant" :label="statusConfig[entry.status].label" />
              </div>
              <p class="text-[11px] text-text-muted leading-tight line-clamp-2 mb-1.5">{{ entry.title }}</p>
              <div class="flex items-center justify-between">
                <span class="font-mono text-[10px] text-text-ghost">{{ entry.date }}</span>
                <span v-if="entry.pnl !== null" :class="['font-mono text-[10px] font-bold', entry.pnl >= 0 ? 'text-profit' : 'text-loss']">
                  {{ entry.pnl >= 0 ? '+' : '' }}${{ Math.abs(entry.pnl) }}
                </span>
              </div>
            </button>
          </div>

          <!-- Stats footer -->
          <div class="border-t border-border p-4 space-y-1.5">
            <div class="flex justify-between">
              <span class="font-mono text-[10px] text-text-ghost">Total entries</span>
              <span class="font-mono text-[10px] text-text-primary">{{ entries.length }}</span>
            </div>
            <div class="flex justify-between">
              <span class="font-mono text-[10px] text-text-ghost">AI analyzed</span>
              <span class="font-mono text-[10px] text-cyan">{{ entries.filter(e => e.status === 'analyzed').length }}</span>
            </div>
          </div>
        </aside>

        <!-- ── Main: entry detail ────────────────────────────── -->
        <main v-if="selected" class="flex-1 overflow-auto p-6 space-y-5">

          <!-- Entry header -->
          <div class="flex items-start justify-between">
            <div>
              <div class="flex items-center gap-2 mb-2">
                <span class="font-mono text-[10px] text-text-ghost">{{ selected.date }}</span>
                <ChevronRight class="h-3 w-3 text-text-ghost" />
                <span class="font-mono text-[10px] text-text-muted">{{ selected.setup }}</span>
              </div>
              <h1 class="text-xl font-bold text-text-primary">{{ selected.title }}</h1>
            </div>
            <div class="flex items-center gap-2 shrink-0">
              <AppBadge :variant="statusConfig[selected.status].variant" :label="statusConfig[selected.status].label" />
              <span v-if="selected.pnl !== null" :class="['font-mono text-sm font-bold', selected.pnl >= 0 ? 'text-profit' : 'text-loss']">
                {{ selected.pnl >= 0 ? '+' : '' }}${{ Math.abs(selected.pnl).toLocaleString() }}
              </span>
            </div>
          </div>

          <!-- Trade metadata -->
          <div class="grid grid-cols-5 gap-2">
            <div v-for="cell in [
              { label: 'Ticker',    value: selected.ticker,    color: 'text-cyan' },
              { label: 'Contract',  value: selected.contract,  color: 'text-text-primary' },
              { label: 'Entry',     value: selected.entryDate, color: 'text-text-primary' },
              { label: 'Exit',      value: selected.exitDate || '—', color: 'text-text-primary' },
              { label: 'Direction', value: directionConfig[selected.direction].label, color: directionConfig[selected.direction].color },
            ]" :key="cell.label"
              class="bg-bg-surface border border-border rounded-card px-3 py-2.5"
            >
              <p class="font-mono text-[9px] uppercase tracking-widest text-text-ghost mb-1">{{ cell.label }}</p>
              <p :class="['font-mono text-[12px] font-semibold', cell.color]">{{ cell.value }}</p>
            </div>
          </div>

          <!-- Score + setup -->
          <div class="bg-bg-surface border border-border rounded-card px-4 py-3 flex items-center gap-6">
            <div class="shrink-0">
              <p class="font-mono text-[9px] uppercase tracking-widest text-text-ghost mb-1.5">Setup Score</p>
              <div class="w-48">
                <ScoreBar :score="selected.score" />
              </div>
            </div>
            <div class="h-6 w-px bg-border" />
            <div>
              <p class="font-mono text-[9px] uppercase tracking-widest text-text-ghost mb-1">Setup</p>
              <p class="text-sm font-medium text-text-primary">{{ selected.setup }}</p>
            </div>
          </div>

          <!-- Thesis + Outcome -->
          <div class="grid grid-cols-2 gap-4">

            <!-- Pre-trade thesis -->
            <div class="bg-bg-surface border border-border rounded-card overflow-hidden">
              <div class="px-4 py-3 border-b border-border flex items-center gap-2">
                <div class="h-1.5 w-1.5 rounded-full bg-cyan" />
                <span class="text-sm font-semibold text-text-primary">Pre-trade Thesis</span>
              </div>
              <div class="p-4">
                <p class="text-[13px] text-text-muted leading-relaxed">{{ selected.thesis }}</p>
              </div>
            </div>

            <!-- Post-trade outcome -->
            <div class="bg-bg-surface border border-border rounded-card overflow-hidden">
              <div class="px-4 py-3 border-b border-border flex items-center gap-2">
                <div :class="['h-1.5 w-1.5 rounded-full', selected.pnl === null ? 'bg-text-ghost' : selected.pnl >= 0 ? 'bg-profit' : 'bg-loss']" />
                <span class="text-sm font-semibold text-text-primary">Post-trade Outcome</span>
              </div>
              <div class="p-4">
                <p v-if="selected.outcome" class="text-[13px] text-text-muted leading-relaxed">{{ selected.outcome }}</p>
                <p v-else class="text-[13px] text-text-ghost italic">Trade still open — outcome pending.</p>
              </div>
            </div>
          </div>

          <!-- ── AI Analysis ────────────────────────────────── -->
          <div class="rounded-card border overflow-hidden"
            :class="showAI ? 'border-violet/30 bg-violet/5' : 'border-border bg-bg-surface'"
          >
            <div class="flex items-center justify-between px-4 py-3 border-b"
              :class="showAI ? 'border-violet/20' : 'border-border'"
            >
              <div class="flex items-center gap-2">
                <Bot :class="['h-4 w-4', showAI ? 'text-violet' : 'text-text-ghost']" />
                <span class="text-sm font-semibold" :class="showAI ? 'text-violet' : 'text-text-primary'">
                  AI Analysis
                </span>
                <AppBadge variant="violet" label="CLAUDE" />
              </div>

              <button
                v-if="!showAI"
                @click="generateAnalysis"
                :disabled="aiLoading"
                class="flex items-center gap-2 bg-violet/15 border border-violet/30 text-violet rounded-chip px-4 py-1.5 font-mono text-[11px] font-bold hover:bg-violet/25 transition-colors disabled:opacity-60"
              >
                <Sparkles :class="['h-3.5 w-3.5', aiLoading && 'animate-pulse']" />
                {{ aiLoading ? 'Analyzing...' : 'Generate Analysis' }}
              </button>
            </div>

            <!-- Loading state -->
            <div v-if="aiLoading" class="p-6 flex items-center gap-3">
              <div class="flex gap-1">
                <div class="h-1.5 w-1.5 rounded-full bg-violet animate-bounce" />
                <div class="h-1.5 w-1.5 rounded-full bg-violet animate-bounce [animation-delay:0.15s]" />
                <div class="h-1.5 w-1.5 rounded-full bg-violet animate-bounce [animation-delay:0.3s]" />
              </div>
              <span class="font-mono text-[11px] text-violet/60">Reviewing trade context...</span>
            </div>

            <!-- AI response -->
            <div v-else-if="showAI && aiResponses[selected.id]" class="p-5 space-y-5">

              <!-- Summary -->
              <p class="text-[13px] text-text-muted leading-relaxed">
                {{ aiResponses[selected.id].summary }}
              </p>

              <!-- Insights -->
              <div class="space-y-3">
                <div class="flex items-center gap-2 mb-2">
                  <Lightbulb class="h-3.5 w-3.5 text-violet" />
                  <span class="font-mono text-[10px] uppercase tracking-widest text-violet/80">Key Insights</span>
                </div>
                <div
                  v-for="(insight, i) in aiResponses[selected.id].insights"
                  :key="i"
                  class="flex gap-3"
                >
                  <div class="font-mono text-[10px] text-violet/50 shrink-0 w-4 pt-0.5">{{ i + 1 }}.</div>
                  <p class="text-[13px] text-text-muted leading-relaxed">{{ insight }}</p>
                </div>
              </div>

              <!-- Recommendation -->
              <div class="bg-violet/8 border border-violet/20 rounded-chip px-4 py-3">
                <p class="font-mono text-[9px] uppercase tracking-widest text-violet/70 mb-1.5">Recommendation</p>
                <p class="text-[12px] text-text-muted leading-relaxed">
                  {{ aiResponses[selected.id].recommendation }}
                </p>
              </div>

              <p class="font-mono text-[9px] text-text-ghost">
                Generated by Claude · Based on trade data, setup config, and journal history
              </p>
            </div>

            <!-- Placeholder when no AI for this entry -->
            <div v-else-if="showAI" class="p-5 text-center text-text-ghost text-sm">
              No AI response available for this entry.
            </div>

            <!-- CTA when not generated yet -->
            <div v-else class="px-5 pb-5 pt-3">
              <p class="text-[12px] text-text-ghost leading-relaxed">
                Claude will review the trade context — setup config, features, entry timing, and outcome —
                and provide specific insights and recommendations for future similar trades.
              </p>
            </div>
          </div>

        </main>
      </div>
</template>
