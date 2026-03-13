<script setup>
import { ref } from 'vue'
import { useWatchlistStore } from '@/modules/watchlists/stores/useWatchlistStore'
import {useRouter} from "vue-router";
import BaseAutocomplete from "@/components/BaseAutocomplete.vue";

const form = ref({
  name: '',
  description: '',
  is_default: false,
  symbol_search: null
})

const symbols = ref([
  { id: 1, name: 'AAPL' },
  { id: 2, name: 'MSFT' },
  { id: 3, name: 'TSLA' },
  { id: 4, name: 'NVDA' },
  { id: 5, name: 'GOOGL' },
  { id: 6, name: 'AMZN' },
  { id: 7, name: 'META' },
])

const loading = ref(false)
const watchlistStore = useWatchlistStore()
const router = useRouter()

const handleSubmit = async () => {
  try {
    loading.value = true

    await watchlistStore.createWatchlist(form.value)

    await router.push({ name: 'watchlists.index' })
  } catch (error) {
    console.error('Failed to create watchlist', error)
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <section class="max-w-4xl p-6 xl:p-8 space-y-10">
    <header class="space-y-4 px-2">
      <div class="flex items-center gap-3">
        <div class="h-4 w-1 rounded-full bg-accent shadow-glow"></div>
        <p class="font-mono text-[10px] font-bold uppercase tracking-[0.4em] text-accent">
          Asset Management
        </p>
      </div>
      <h1 class="text-4xl font-black tracking-tight text-white md:text-5xl">
        Create
        <span class="bg-gradient-to-r from-white via-[#ffd089] to-accent bg-clip-text text-transparent">
          Watchlist
        </span>
      </h1>
      <p class="max-w-xl text-sm font-medium leading-relaxed text-text-secondary">
        Create a new watchlist to organize symbols by strategy, theme, or priority.
        <span class="text-white/70">Scale your monitoring with custom terminal views.</span>
      </p>
    </header>

    <div class="relative overflow-hidden rounded-[30px] border border-accent/20 bg-[linear-gradient(180deg,rgba(12,12,13,0.98),rgba(4,4,5,1))] p-10 shadow-[0_24px_90px_rgba(0,0,0,0.65)]">
      <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/60 to-transparent"></div>
      <div class="absolute -right-20 top-0 h-64 w-64 rounded-full bg-accent/10 blur-[120px]"></div>

      <form @submit.prevent="handleSubmit" class="relative z-10 space-y-10">
        <div class="grid gap-8 md:grid-cols-2">
          <div class="space-y-3">
            <label
                for="name"
                class="ml-1 font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-white/60"
            >
              Watchlist Name
            </label>
            <input
                id="name"
                v-model="form.name"
                type="text"
                required
                class="w-full rounded-2xl border border-white/12 bg-[linear-gradient(180deg,rgba(17,17,19,0.98),rgba(11,11,12,1))] px-5 py-4 text-sm text-white placeholder:text-white/20 outline-none transition-all duration-300 focus:border-accent/35 focus:bg-accent/[0.04] focus:shadow-[0_0_0_1px_rgba(255,138,0,0.15),0_0_24px_rgba(255,138,0,0.10)]"
                placeholder="e.g. Core Swings, High Growth"
            />
          </div>

          <BaseAutocomplete
            v-model="form.symbol_search"
            :items="symbols"
            label="Initial Symbol Allocation"
            placeholder="Search symbol (e.g. AAPL...)"
            item-text="name"
            item-value="id"
          />
        </div>

        <div class="grid gap-8 md:grid-cols-2">
          <div class="flex items-end pb-1">
            <label class="group/label flex cursor-pointer items-center gap-4 rounded-2xl border border-white/5 bg-white/[0.02] p-4 pr-6 transition-all hover:border-accent/30 hover:bg-accent/[0.04]">
              <div class="relative flex items-center">
                <input
                    v-model="form.is_default"
                    type="checkbox"
                    class="peer h-6 w-6 cursor-pointer appearance-none rounded-lg border border-white/12 bg-background transition-all checked:border-accent checked:bg-accent"
                />
                <svg class="absolute left-1 top-1 hidden h-4 w-4 pointer-events-none text-black peer-checked:block" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
              </div>
              <div class="space-y-0.5">
                <span class="block text-xs font-black uppercase tracking-widest text-white group-hover/label:text-accent transition-colors">Set as Primary</span>
                <span class="block text-[10px] font-medium text-text-secondary">Default for new symbol allocations</span>
              </div>
            </label>
          </div>
        </div>

        <div class="space-y-3">
          <label
              for="description"
              class="ml-1 font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-white/60"
          >
            Terminal Description
          </label>
          <textarea
              id="description"
              v-model="form.description"
              rows="4"
              class="w-full rounded-2xl border border-white/12 bg-[linear-gradient(180deg,rgba(17,17,19,0.98),rgba(11,11,12,1))] px-5 py-4 text-sm text-white placeholder:text-white/20 outline-none transition-all duration-300 focus:border-accent/35 focus:bg-accent/[0.04] focus:shadow-[0_0_0_1px_rgba(255,138,0,0.15),0_0_24px_rgba(255,138,0,0.10)] resize-none"
              placeholder="Describe the strategy or focus of this watchlist..."
          />
        </div>

        <div class="flex items-center gap-6 pt-6 border-t border-white/5">
          <button
              type="submit"
              :disabled="loading"
              class="inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-accent to-[#ff6a00] px-10 py-4 text-[11px] font-black uppercase tracking-[0.25em] text-black transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_35px_rgba(255,138,0,0.4)] disabled:cursor-not-allowed disabled:opacity-50"
          >
            <span v-if="!loading">Initialize Watchlist</span>
            <span v-else class="flex items-center gap-3">
              <svg class="h-4 w-4 animate-spin text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
              </svg>
              Allocating...
            </span>
          </button>

          <RouterLink
            :to="{ name: 'watchlists.index' }"
            class="font-mono text-[11px] font-bold uppercase tracking-[0.3em] text-white/40 hover:text-white transition-colors"
          >
            Cancel
          </RouterLink>
        </div>
      </form>
    </div>
  </section>
</template>
