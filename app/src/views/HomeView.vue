<template>
  <main class="relative min-h-screen overflow-hidden bg-black text-text-primary">
    <!-- Background ambience -->
    <div class="pointer-events-none absolute inset-0">
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,138,0,0.18),transparent_22%)]"></div>
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(255,138,0,0.10),transparent_28%)]"></div>
      <div class="absolute inset-0 bg-[linear-gradient(to_bottom,rgba(255,255,255,0.015),transparent_20%,transparent_78%,rgba(255,138,0,0.06))]"></div>
    </div>

    <div class="relative mx-auto flex min-h-screen max-w-7xl items-center px-6 py-10">
      <div class="grid w-full items-center gap-14 xl:grid-cols-[1.05fr_0.95fr]">
        <!-- Left -->
        <section class="max-w-2xl space-y-8">
          <div class="space-y-5">
            <p class="font-mono text-[11px] font-bold uppercase tracking-[0.45em] text-white/70">
              SMARTEDGE LAB
            </p>

            <h1 class="text-5xl font-black leading-[0.9] tracking-tight md:text-7xl">
              <span class="block text-white">Trading</span>
              <span class="block bg-gradient-to-r from-white via-[#ffd089] to-accent bg-clip-text text-transparent">
                intelligence
              </span>
              <span class="block text-white">for real</span>
              <span class="block text-white">execution</span>
            </h1>

            <p class="max-w-xl text-base leading-8 text-text-secondary md:text-lg">
              A focused workspace for watchlists, setups, paper trades, and trading review.
              Built for clarity, discipline, and
              <span class="text-accent"> better decision-making.</span>
            </p>
          </div>

          <div class="flex flex-wrap items-center gap-4 pt-2">
            <router-link
                to="/login"
                class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-accent to-[#ff6a00] px-8 py-3.5 text-sm font-bold uppercase tracking-[0.2em] text-black transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_30px_rgba(255,138,0,0.35)]"
            >
              Enter Workspace
            </router-link>

            <div
                class="inline-flex items-center gap-3 rounded-xl border border-accent/25 bg-[linear-gradient(180deg,rgba(255,138,0,0.10),rgba(255,138,0,0.03))] px-5 py-3 text-sm text-white shadow-[0_0_20px_rgba(255,138,0,0.10)]"
            >
              <div class="h-2.5 w-2.5 rounded-full bg-success shadow-[0_0_12px_rgba(16,185,129,0.8)]"></div>
              <span>System ready</span>
            </div>
          </div>

          <!-- Big orange block -->
          <div
              class="relative overflow-hidden rounded-[24px] border border-accent/30 bg-gradient-to-br from-accent via-[#ff9a1f] to-[#ff6a00] p-7 text-black shadow-[0_30px_80px_rgba(255,138,0,0.28)]"
          >
            <div class="absolute inset-y-0 right-0 w-48 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.22),transparent_60%)]"></div>

            <div class="relative z-10 grid gap-6 md:grid-cols-[1fr_auto] md:items-center">
              <div>
                <p class="font-mono text-[10px] font-black uppercase tracking-[0.3em] text-black/75">
                  SmartEdge Engine
                </p>
                <h2 class="mt-3 text-3xl font-black leading-tight md:text-4xl">
                  TOP-TIER SYSTEM
                  <span class="block">SPEED</span>
                </h2>
              </div>

              <div class="flex justify-start md:justify-end">
                <div class="relative h-28 w-28 rounded-full border-8 border-black/80">
                  <div class="absolute inset-3 rounded-full border-[6px] border-black/50"></div>
                  <div class="absolute inset-[26px] flex items-center justify-center rounded-full bg-black text-xl font-black text-accent">
                    TOP
                  </div>

                  <div class="absolute -left-8 top-1/2 h-px w-8 bg-black/60"></div>
                  <div class="absolute -right-8 top-1/2 h-px w-8 bg-black/60"></div>
                  <div class="absolute left-1/2 -top-8 h-8 w-px bg-black/60"></div>
                  <div class="absolute bottom-[-2rem] left-1/2 h-8 w-px bg-black/60"></div>

                  <span class="absolute -left-14 top-[46%] text-[11px] font-black text-black/75">CLS</span>
                  <span class="absolute -right-14 top-[46%] text-[11px] font-black text-black/75">LCP</span>
                  <span class="absolute left-[44%] -top-7 text-[11px] font-black text-black/75">S1</span>
                  <span class="absolute left-[42%] -bottom-7 text-[11px] font-black text-black/75">TBT</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Bottom small cards -->
          <div class="grid max-w-2xl gap-4 sm:grid-cols-3">
            <div
                class="rounded-2xl border border-border bg-[linear-gradient(180deg,rgba(17,17,19,0.96),rgba(10,10,10,0.98))] p-5 shadow-soft transition-all duration-300 hover:border-accent/25"
            >
              <p class="font-mono text-[10px] font-bold uppercase tracking-[0.28em] text-white/70">
                Focus
              </p>
              <p class="mt-4 text-2xl font-black text-white">Setups</p>
            </div>

            <div
                class="rounded-2xl border border-accent/30 bg-[linear-gradient(180deg,rgba(255,138,0,0.18),rgba(255,138,0,0.05))] p-5 shadow-[0_0_24px_rgba(255,138,0,0.14)] transition-all duration-300 hover:border-accent/45"
            >
              <p class="font-mono text-[10px] font-bold uppercase tracking-[0.28em] text-[#ffd089]">
                Tracking
              </p>
              <p class="mt-4 text-2xl font-black text-white">Watchlists</p>
            </div>

            <div
                class="rounded-2xl border border-border bg-[linear-gradient(180deg,rgba(17,17,19,0.96),rgba(10,10,10,0.98))] p-5 shadow-soft transition-all duration-300 hover:border-accent/25"
            >
              <p class="font-mono text-[10px] font-bold uppercase tracking-[0.28em] text-white/70">
                Review
              </p>
              <p class="mt-4 text-2xl font-black text-white">Journal</p>
            </div>
          </div>
        </section>

        <!-- Right -->
        <section class="flex justify-center xl:justify-end">
          <div
              class="relative w-full max-w-xl overflow-hidden rounded-[30px] border border-accent/24 bg-[linear-gradient(180deg,rgba(12,12,13,0.98),rgba(4,4,5,1))] p-6 shadow-[0_24px_90px_rgba(0,0,0,0.65)]"
          >
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/70 to-transparent"></div>
            <div class="absolute -right-20 top-0 h-64 w-64 rounded-full bg-accent/20 blur-[120px]"></div>
            <div class="absolute bottom-0 left-0 h-48 w-48 rounded-full bg-[#ffb84d]/10 blur-[100px]"></div>

            <div class="relative z-10 space-y-6">
              <div class="flex items-start justify-between">
                <div>
                  <p class="font-mono text-[10px] font-bold uppercase tracking-[0.35em] text-white/65">
                    SmartEdge Terminal
                  </p>
                  <h2 class="mt-3 text-3xl font-black tracking-tight text-white">
                    Ready to
                    <span class="text-accent">trade</span>
                  </h2>
                </div>

                <div class="rounded-xl border border-white/15 bg-white/[0.03] px-3 py-2 text-[10px] font-bold uppercase tracking-[0.22em] text-white">
                  Live
                </div>
              </div>

              <div class="grid gap-4 sm:grid-cols-2">
                <div
                    class="rounded-2xl border border-white/12 bg-[linear-gradient(180deg,rgba(16,16,18,0.98),rgba(8,8,9,1))] px-5 py-4"
                >
                  <p class="font-mono text-[10px] font-bold uppercase tracking-[0.24em] text-white/60">
                    Session
                  </p>
                  <p class="mt-3 text-2xl font-black text-white">Ready</p>
                </div>

                <div
                    class="rounded-2xl border border-accent/28 bg-[linear-gradient(180deg,rgba(255,138,0,0.20),rgba(255,138,0,0.06))] px-5 py-4 shadow-[0_0_22px_rgba(255,138,0,0.14)]"
                >
                  <p class="font-mono text-[10px] font-bold uppercase tracking-[0.24em] text-[#ffd089]">
                    Active Lists
                  </p>
                  <p class="mt-3 text-2xl font-black text-white">03</p>
                </div>
              </div>

              <div class="rounded-2xl border border-white/10 bg-[linear-gradient(180deg,rgba(12,12,13,0.98),rgba(8,8,9,1))] p-4">
                <div class="mb-4 flex items-center justify-between">
                  <p class="font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-white/65">
                    Core Universe
                  </p>
                  <span class="rounded-lg border border-accent/28 bg-accent-soft px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-accent">
                    Monitored
                  </span>
                </div>

                <div class="space-y-3">
                  <div
                      class="flex items-center justify-between rounded-xl border border-white/10 bg-[linear-gradient(180deg,rgba(17,17,19,0.98),rgba(11,11,12,1))] px-4 py-3 transition-all duration-300 hover:border-accent/25 hover:bg-accent/[0.05]"
                  >
                    <span class="font-semibold text-white">NVDA</span>
                    <span class="text-xs font-semibold text-[#ffbe5c]">Momentum</span>
                  </div>

                  <div
                      class="flex items-center justify-between rounded-xl border border-white/10 bg-[linear-gradient(180deg,rgba(17,17,19,0.98),rgba(11,11,12,1))] px-4 py-3 transition-all duration-300 hover:border-accent/25 hover:bg-accent/[0.05]"
                  >
                    <span class="font-semibold text-white">AAPL</span>
                    <span class="text-xs font-semibold text-[#ffbe5c]">Structure</span>
                  </div>

                  <div
                      class="flex items-center justify-between rounded-xl border border-white/10 bg-[linear-gradient(180deg,rgba(17,17,19,0.98),rgba(11,11,12,1))] px-4 py-3 transition-all duration-300 hover:border-accent/25 hover:bg-accent/[0.05]"
                  >
                    <span class="font-semibold text-white">QQQ</span>
                    <span class="text-xs font-semibold text-[#ffbe5c]">Context</span>
                  </div>
                </div>
              </div>

              <router-link
                  to="/login"
                  class="inline-flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-accent to-[#ff6a00] px-6 py-3.5 text-sm font-bold uppercase tracking-[0.22em] text-black transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_28px_rgba(255,138,0,0.35)]"
              >
                Launch Terminal
              </router-link>
            </div>
          </div>
        </section>
      </div>
    </div>
  </main>
</template>

<script setup>
// Minimal logic
</script>
