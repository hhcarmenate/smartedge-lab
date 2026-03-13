<script setup>
import { onMounted, ref } from 'vue'
import { useWatchlistStore } from '@/modules/watchlists/stores/useWatchlistStore'
import BaseModal from '@/components/BaseModal.vue'

const watchlistStore = useWatchlistStore()
const showTestModal = ref(false)

onMounted(() => {
  watchlistStore.fetchWatchlists()
})
</script>

<template>
  <section class="p-6 xl:p-8 space-y-12">
    <header class="relative flex items-end justify-between overflow-hidden rounded-[30px] border border-accent/20 bg-[linear-gradient(180deg,rgba(14,14,15,0.98),rgba(6,6,7,1))] p-10 shadow-[0_18px_55px_rgba(0,0,0,0.45)]">
      <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/60 to-transparent"></div>
      <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-accent/10 blur-[90px]"></div>

      <div class="relative z-10">
        <div class="mb-4 flex items-center gap-2">
          <div class="h-3 w-1 rounded-full bg-accent shadow-glow"></div>
          <p class="font-mono text-[10px] font-bold uppercase tracking-[0.35em] text-accent/85">
            Asset Management
          </p>
        </div>
        <h1 class="text-4xl font-black tracking-tight text-white md:text-5xl">
          Market
          <span class="bg-gradient-to-r from-white via-[#ffd089] to-accent bg-clip-text text-transparent">
            Watchlists
          </span>
        </h1>
        <p class="mt-4 max-w-xl text-sm font-medium leading-relaxed text-text-secondary">
          Curated market segments and high-probability setups.
          <span class="text-white/70">Organize your trading strategy with precision and speed.</span>
        </p>
      </div>

      <button
          @click="showTestModal = true"
          class="group relative z-10 flex items-center gap-3 overflow-hidden rounded-xl bg-white/5 border border-white/10 px-8 py-4 text-[11px] font-black uppercase tracking-[0.2em] text-white transition-all duration-300 hover:bg-white/10 active:scale-[0.98]"
      >
        <span>Open Terminal</span>
      </button>

      <RouterLink
          :to="{ name: 'watchlists.create' }"
          class="group relative z-10 flex items-center gap-3 overflow-hidden rounded-xl bg-gradient-to-r from-accent to-[#ff6a00] px-8 py-4 text-[11px] font-black uppercase tracking-[0.2em] text-black transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_30px_rgba(255,138,0,0.35)] active:scale-[0.98]"
      >
        <span>Create New List</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
      </RouterLink>
    </header>

    <div v-if="watchlistStore.loading" class="flex items-center gap-4 px-4 font-mono text-xs tracking-widest text-accent/60">
      <div class="flex gap-1">
        <div class="h-1 w-1 animate-bounce bg-accent rounded-full"></div>
        <div class="h-1 w-1 animate-bounce bg-accent rounded-full [animation-delay:0.2s]"></div>
        <div class="h-1 w-1 animate-bounce bg-accent rounded-full [animation-delay:0.4s]"></div>
      </div>
      Synchronizing terminal data...
    </div>

    <div
        v-else-if="watchlistStore.watchlists.length"
        class="grid gap-8 md:grid-cols-2 xl:grid-cols-3"
    >
      <RouterLink
          v-for="watchlist in watchlistStore.watchlists"
          :key="watchlist.id"
          :to="{ name: 'watchlists.show', params: { id: watchlist.id } }"
          class="group relative overflow-hidden rounded-[28px] border border-white/10 bg-[linear-gradient(180deg,rgba(14,14,15,0.98),rgba(6,6,7,1))] p-8 shadow-[0_12px_40px_rgba(0,0,0,0.35)] transition-all duration-500 hover:border-accent/40 hover:shadow-[0_20px_60px_rgba(255,138,0,0.12)]"
      >
        <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent group-hover:via-accent/50 transition-all duration-500"></div>
        <div class="absolute -right-10 -top-10 h-32 w-32 rounded-full bg-accent/5 blur-3xl transition-all duration-700 group-hover:bg-accent/15 group-hover:blur-2xl"></div>

        <div class="relative z-10">
          <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-2">
              <div class="h-2 w-0.5 bg-accent/40 group-hover:bg-accent transition-colors"></div>
              <p class="font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-white/40 group-hover:text-accent/80 transition-colors">
                DIR / {{ watchlist.id.toString().padStart(2, '0') }}
              </p>
            </div>
            <div class="flex h-9 w-9 items-center justify-center rounded-xl border border-white/10 bg-white/[0.03] transition-all duration-300 group-hover:border-accent/30 group-hover:bg-accent/10 group-hover:text-accent group-hover:shadow-[0_0_15px_rgba(255,138,0,0.15)]">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
            </div>
          </div>

          <h2 class="text-2xl font-black tracking-tight text-white group-hover:text-accent transition-colors duration-300">
            {{ watchlist.name }}
          </h2>

          <p class="mt-4 line-clamp-2 h-10 text-sm font-medium leading-relaxed text-text-secondary opacity-70 group-hover:opacity-100 transition-opacity">
            {{ watchlist.description || 'Professional trading watchlist without description.' }}
          </p>

          <div class="mt-8 space-y-5 border-t border-white/5 pt-6 group-hover:border-accent/10 transition-colors">
            <div class="flex items-center justify-between">
              <span class="font-mono text-[10px] font-bold uppercase tracking-[0.25em] text-white/30 group-hover:text-accent/60 transition-colors">Allocation</span>
              <span class="rounded-lg border border-accent/20 bg-accent/10 px-2.5 py-1 font-mono text-[10px] font-black text-accent shadow-[0_0_10px_rgba(255,138,0,0.1)]">
                {{ watchlist.items?.length || 0 }} SYMBOLS
              </span>
            </div>

            <div
                v-if="watchlist.items?.length"
                class="flex flex-wrap gap-2"
            >
              <span
                  v-for="item in watchlist.items.slice(0, 4)"
                  :key="item.id"
                  class="rounded-lg border border-white/10 bg-white/[0.03] px-3 py-1.5 font-mono text-[10px] font-bold text-text-secondary transition-all duration-300 group-hover:border-accent/20 group-hover:bg-accent/[0.05] group-hover:text-accent"
              >
                {{ item.symbol?.ticker ?? '' }}
              </span>
              <div v-if="watchlist.items.length > 4" class="flex h-7 w-7 items-center justify-center rounded-lg border border-white/5 bg-white/[0.02] font-mono text-[10px] text-white/30">
                +{{ watchlist.items.length - 4 }}
              </div>
            </div>

            <p
                v-else
                class="font-mono text-[10px] italic tracking-wider text-white/20"
            >
              // Waiting for signals
            </p>
          </div>
        </div>
      </RouterLink>
    </div>

    <div
        v-else
        class="relative flex flex-col items-center justify-center overflow-hidden rounded-[30px] border-2 border-dashed border-white/10 bg-[linear-gradient(180deg,rgba(12,12,13,0.5),transparent)] p-20 text-center shadow-inner"
    >
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,rgba(255,138,0,0.03),transparent_70%)]"></div>

      <div class="relative mb-8 flex h-24 w-24 items-center justify-center rounded-full border border-white/5 bg-white/[0.03] shadow-soft">
        <div class="absolute inset-0 rounded-full bg-accent/5 blur-xl"></div>
        <span class="text-4xl grayscale opacity-40 group-hover:grayscale-0 transition-all">📂</span>
      </div>

      <div class="relative z-10 max-w-xs space-y-4">
        <h3 class="text-xl font-black tracking-tight text-white">
          Terminal Empty
        </h3>
        <p class="text-sm font-medium leading-relaxed text-text-secondary">
          No active watchlists detected in the current session. Initialize your first list to begin tracking.
        </p>
        <RouterLink
            :to="{ name: 'watchlists.create' }"
            class="mt-6 inline-flex items-center gap-2 font-mono text-[11px] font-black uppercase tracking-[0.25em] text-accent transition-all hover:text-accent-hover hover:gap-3"
        >
          Initialize First List
          <span class="text-lg">→</span>
        </RouterLink>
      </div>
    </div>
  </section>

  <BaseModal
    :show="showTestModal"
    title="Terminal Authorization"
    @close="showTestModal = false"
  >
    <div class="space-y-4">
      <p class="text-text-secondary text-sm leading-relaxed">
        You are attempting to access the high-frequency trading terminal. Please confirm your identity to proceed with the synchronization.
      </p>

      <div class="rounded-xl border border-accent/20 bg-accent/5 p-4">
        <div class="flex items-center gap-3">
          <div class="h-2 w-2 animate-pulse rounded-full bg-accent shadow-[0_0_10px_rgba(255,138,0,0.5)]"></div>
          <span class="font-mono text-[10px] font-bold uppercase tracking-widest text-accent">Status: Awaiting Input</span>
        </div>
      </div>
    </div>

    <template #footer>
      <button
        @click="showTestModal = false"
        class="rounded-xl px-6 py-3 text-[11px] font-bold uppercase tracking-widest text-text-muted transition-colors hover:text-white"
      >
        Cancel
      </button>
      <button
        @click="showTestModal = false"
        class="rounded-xl bg-accent px-6 py-3 text-[11px] font-black uppercase tracking-widest text-black transition-all hover:brightness-110 hover:shadow-glow"
      >
        Confirm Access
      </button>
    </template>
  </BaseModal>
</template>
