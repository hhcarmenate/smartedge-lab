<script setup>
const coreTickers = ['NVDA', 'AMD', 'AAPL', 'QQQ', 'SPY']

const signals = [
  {
    icon: 'N',
    ticker: 'NVDA',
    timeframe: '1H / 15M',
    title: 'Pullback continuation setup',
    confidence: '92%',
    grade: 'A',
    tone: 'success',
  },
  {
    icon: 'A',
    ticker: 'AMD',
    timeframe: '1D / 1H',
    title: 'Breakout retest validation',
    confidence: '88%',
    grade: 'A-',
    tone: 'success',
  },
  {
    icon: 'A',
    ticker: 'AAPL',
    timeframe: '1H / 15M',
    title: 'Compression setup forming',
    confidence: '76%',
    grade: 'B+',
    tone: 'accent',
  },
]
</script>

<template>
  <div class="space-y-8">
    <!-- Top cards -->
    <section class="grid gap-6 xl:grid-cols-3 p-6 xl:p-8">
      <article
          class="relative overflow-hidden rounded-[28px] p-2 border border-accent/18 bg-[linear-gradient(180deg,rgba(14,14,15,0.98),rgba(6,6,7,1))] p-6 shadow-[0_18px_55px_rgba(0,0,0,0.45)]"
      >
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-success/50 to-transparent"></div>
        <div class="absolute -left-10 top-0 h-32 w-32 rounded-full bg-success/10 blur-[70px]"></div>

        <div class="relative z-10">
          <div class="mb-4 flex items-center gap-2">
            <div class="h-3 w-1 rounded-full bg-success shadow-[0_0_10px_rgba(16,185,129,0.45)]"></div>
            <p class="font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-success/80">
              Primary Setup
            </p>
          </div>

          <h2 class="text-3xl font-black tracking-tight text-white">
            NVDA
            <span class="text-[#7ef0ba]">Pullback</span>
          </h2>

          <p class="mt-3 max-w-sm text-sm font-medium leading-relaxed text-text-secondary">
            1H trend intact, 15M timing forming near EMA20.
            <span class="text-white/70">High probability continuation.</span>
          </p>

          <div class="mt-6 flex items-center justify-between">
            <span class="rounded-xl border border-success/25 bg-success/10 px-3.5 py-2 text-[10px] font-black uppercase tracking-[0.18em] text-success">
              Score A
            </span>
            <span class="font-mono text-xs font-bold text-white/60">+2.4 ATR</span>
          </div>
        </div>
      </article>

      <article
          class="relative overflow-hidden rounded-[28px] border border-accent/20 bg-[linear-gradient(180deg,rgba(14,14,15,0.98),rgba(6,6,7,1))] p-6 shadow-[0_18px_55px_rgba(0,0,0,0.45)]"
      >
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/60 to-transparent"></div>
        <div class="absolute right-0 top-0 h-40 w-40 rounded-full bg-accent/12 blur-[90px]"></div>

        <div class="relative z-10">
          <div class="mb-4 flex items-center gap-2">
            <div class="h-3 w-1 rounded-full bg-accent shadow-glow"></div>
            <p class="font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-accent/85">
              Market Context
            </p>
          </div>

          <h2 class="text-3xl font-black tracking-tight text-white">
            <span class="bg-gradient-to-r from-white via-[#ffd089] to-accent bg-clip-text text-transparent">
              Constructive
            </span>
          </h2>

          <p class="mt-3 max-w-sm text-sm font-medium leading-relaxed text-text-secondary">
            SPY and QQQ above key moving averages.
            <span class="text-white/70">Breadth supportive.</span>
          </p>

          <div class="mt-6 flex flex-wrap gap-2">
            <span class="rounded-xl border border-accent/25 bg-accent-soft px-3.5 py-2 text-[10px] font-black uppercase tracking-[0.14em] text-accent">
              SPY Bullish
            </span>
            <span class="rounded-xl border border-accent/25 bg-accent-soft px-3.5 py-2 text-[10px] font-black uppercase tracking-[0.14em] text-accent">
              QQQ Bullish
            </span>
          </div>
        </div>
      </article>

      <article
          class="relative overflow-hidden rounded-[28px] border border-accent/18 bg-[linear-gradient(180deg,rgba(14,14,15,0.98),rgba(6,6,7,1))] p-6 shadow-[0_18px_55px_rgba(0,0,0,0.45)]"
      >
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-warning/50 to-transparent"></div>
        <div class="absolute -right-8 top-4 h-36 w-36 rounded-full bg-warning/10 blur-[80px]"></div>

        <div class="relative z-10">
          <div class="mb-4 flex items-center gap-2">
            <div class="h-3 w-1 rounded-full bg-warning shadow-[0_0_10px_rgba(255,138,0,0.45)]"></div>
            <p class="font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-warning/85">
              Paper Trade
            </p>
          </div>

          <h2 class="text-3xl font-black tracking-tight text-white">
            Sim
            <span class="text-accent">Queue</span>
          </h2>

          <p class="mt-3 max-w-sm text-sm font-medium leading-relaxed text-text-secondary">
            2 active simulations tracking stop and target.
            <span class="text-white/70">Automated exit layers active.</span>
          </p>

          <div class="mt-6 flex items-center justify-between">
            <span class="rounded-xl border border-warning/25 bg-warning/10 px-3.5 py-2 text-[10px] font-black uppercase tracking-[0.18em] text-warning">
              2 Active
            </span>
            <span class="font-mono text-xs font-bold text-white/60">Win rate 62%</span>
          </div>
        </div>
      </article>
    </section>

    <!-- Main grid -->
    <section class="grid gap-8 xl:grid-cols-[1.45fr_0.75fr] p-6 xl:p-8">
      <!-- Left main -->
      <div class="space-y-8">
        <!-- Signals -->
        <section
            class="relative overflow-hidden rounded-[30px] border border-accent/16 bg-[linear-gradient(180deg,rgba(12,12,13,0.98),rgba(6,6,7,1))] p-8 shadow-[0_22px_70px_rgba(0,0,0,0.48)]"
        >
          <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/50 to-transparent"></div>
          <div class="absolute right-0 top-10 h-48 w-48 rounded-full bg-accent/10 blur-[110px]"></div>

          <div class="relative z-10 mb-8 flex items-start justify-between gap-4">
            <div>
              <h3 class="font-mono text-[11px] font-black uppercase tracking-[0.4em] text-white/70">
                Signals Feed
              </h3>
              <p class="mt-2 text-base font-semibold text-white">Top ranked alpha opportunities</p>
            </div>

            <button
                type="button"
                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-accent to-[#ff6a00] px-6 py-2.5 text-[10px] font-black uppercase tracking-[0.16em] text-black transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_26px_rgba(255,138,0,0.28)]"
            >
              View all signals
            </button>
          </div>

          <div class="relative z-10 space-y-4">
            <div
                v-for="signal in signals"
                :key="signal.ticker"
                class="group relative overflow-hidden rounded-[22px] border border-white/10 bg-[linear-gradient(180deg,rgba(17,17,19,0.98),rgba(10,10,10,1))] p-5 transition-all duration-300 hover:-translate-y-0.5"
                :class="
                signal.tone === 'success'
                  ? 'hover:border-success/28 hover:shadow-[0_0_24px_rgba(16,185,129,0.10)]'
                  : 'hover:border-accent/28 hover:shadow-[0_0_24px_rgba(255,138,0,0.10)]'
              "
            >
              <div
                  class="absolute inset-0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                  :class="
                  signal.tone === 'success'
                    ? 'bg-[linear-gradient(135deg,rgba(16,185,129,0.05),transparent_40%)]'
                    : 'bg-[linear-gradient(135deg,rgba(255,138,0,0.06),transparent_40%)]'
                "
              ></div>

              <div class="relative z-10 flex items-center justify-between gap-5">
                <div class="flex items-center gap-5">
                  <div
                      class="flex h-12 w-12 items-center justify-center rounded-2xl border bg-black/40 font-mono text-base font-black transition-all duration-300"
                      :class="
                      signal.tone === 'success'
                        ? 'border-success/18 text-success group-hover:border-success/28'
                        : 'border-accent/18 text-accent group-hover:border-accent/28'
                    "
                  >
                    {{ signal.icon }}
                  </div>

                  <div>
                    <div class="flex items-center gap-3">
                      <span class="font-mono text-2xl font-black tracking-tight text-white">
                        {{ signal.ticker }}
                      </span>

                      <span
                          class="rounded-lg px-2.5 py-1 text-[9px] font-black uppercase tracking-[0.14em]"
                          :class="
                          signal.tone === 'success'
                            ? 'border border-success/22 bg-success/10 text-success'
                            : 'border border-accent/22 bg-accent/10 text-accent'
                        "
                      >
                        {{ signal.timeframe }}
                      </span>
                    </div>

                    <p class="mt-1.5 text-sm font-medium text-text-secondary">
                      {{ signal.title }}
                    </p>
                  </div>
                </div>

                <div class="flex items-center gap-4">
                  <div class="text-right">
                    <p class="font-mono text-[10px] font-bold uppercase tracking-[0.12em] text-white/45">
                      Confidence
                    </p>
                    <p
                        class="mt-1 text-sm font-black"
                        :class="signal.tone === 'success' ? 'text-success' : 'text-accent'"
                    >
                      {{ signal.confidence }}
                    </p>
                  </div>

                  <span
                      class="rounded-xl px-4 py-2 text-sm font-black"
                      :class="
                      signal.tone === 'success'
                        ? 'border border-success/24 bg-success/10 text-success'
                        : 'border border-accent/24 bg-accent/12 text-accent'
                    "
                  >
                    {{ signal.grade }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Bottom hero block -->
        <section
            class="relative overflow-hidden rounded-[28px] border border-accent/26 bg-gradient-to-br from-accent via-[#ff9a1f] to-[#ff6a00] p-7 text-black shadow-[0_28px_80px_rgba(255,138,0,0.24)]"
        >
          <div class="absolute inset-y-0 right-0 w-48 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.22),transparent_60%)]"></div>

          <div class="relative z-10 grid gap-6 md:grid-cols-[1fr_auto] md:items-center">
            <div>
              <p class="font-mono text-[10px] font-black uppercase tracking-[0.28em] text-black/75">
                SmartEdge Engine
              </p>
              <h3 class="mt-3 text-4xl font-black leading-tight">
                TOP-RANKED
                <span class="block">SETUP FLOW</span>
              </h3>
              <p class="mt-3 max-w-lg text-sm font-semibold text-black/75">
                Keep the workspace focused on aligned structure, quality timing, and clean execution.
              </p>
            </div>

            <div class="flex justify-start md:justify-end">
              <div class="relative h-28 w-28 rounded-full border-8 border-black/80">
                <div class="absolute inset-3 rounded-full border-[6px] border-black/50"></div>
                <div class="absolute inset-[26px] rounded-full bg-black"></div>
              </div>
            </div>
          </div>
        </section>
      </div>

      <!-- Right column -->
      <div class="space-y-8">
        <section
            class="relative overflow-hidden rounded-[28px] border border-accent/16 bg-[linear-gradient(180deg,rgba(12,12,13,0.98),rgba(6,6,7,1))] p-8 shadow-[0_20px_60px_rgba(0,0,0,0.45)]"
        >
          <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(255,138,0,0.03),transparent_28%)]"></div>

          <div class="relative z-10">
            <h3 class="font-mono text-[11px] font-black uppercase tracking-[0.4em] text-white/70">
              Core Monitor
            </h3>

            <div class="mt-6 space-y-3">
              <div
                  v-for="ticker in coreTickers"
                  :key="ticker"
                  class="group flex items-center justify-between rounded-[18px] border border-white/10 bg-[linear-gradient(180deg,rgba(17,17,19,0.98),rgba(10,10,10,1))] px-5 py-4 transition-all duration-300 hover:border-accent/24 hover:bg-accent/[0.04]"
              >
                <div class="flex items-center gap-3">
                  <div class="h-2.5 w-2.5 rounded-full bg-accent/35 transition-all duration-300 group-hover:bg-accent group-hover:shadow-glow"></div>
                  <span class="font-mono text-lg font-black text-white transition-colors duration-300 group-hover:text-accent">
                    {{ ticker }}
                  </span>
                </div>

                <span class="font-mono text-[9px] font-bold uppercase tracking-[0.16em] text-white/50 transition-colors duration-300 group-hover:text-accent">
                  Tracking active
                </span>
              </div>
            </div>
          </div>
        </section>

        <section
            class="relative overflow-hidden rounded-[28px] border border-accent/16 bg-[linear-gradient(180deg,rgba(12,12,13,0.98),rgba(6,6,7,1))] p-8 shadow-[0_20px_60px_rgba(0,0,0,0.45)]"
        >
          <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/35 to-transparent"></div>
          <div class="absolute -right-10 top-6 h-28 w-28 rounded-full bg-accent/10 blur-[70px]"></div>

          <div class="relative z-10">
            <div class="mb-6 flex items-center gap-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-xl border border-accent/18 bg-accent/10 text-lg">
                📝
              </div>
              <h3 class="font-mono text-[11px] font-black uppercase tracking-[0.4em] text-white/70">
                Strategy Insight
              </h3>
            </div>

            <div class="relative rounded-[22px] border border-white/10 bg-[linear-gradient(180deg,rgba(18,18,20,0.98),rgba(10,10,10,1))] p-5">
              <span class="absolute -top-3 left-4 px-2 text-[22px] leading-none text-accent/35">“</span>

              <p class="text-sm font-medium italic leading-7 text-text-secondary">
                Best setups continue to come from aligned 1D + 1H structure. Avoid forcing entries
                when market context is mixed.
              </p>
            </div>
          </div>
        </section>
      </div>
    </section>
  </div>
</template>

<style scoped>
</style>
