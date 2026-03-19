<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useWatchlistStore } from '@/modules/watchlists/stores/useWatchlistStore'
import { ArrowLeft } from 'lucide-vue-next'

const router = useRouter()
const watchlistStore = useWatchlistStore()

const form = ref({
  name: '',
  description: '',
  is_default: false,
})

const handleSubmit = async () => {
  try {
    await watchlistStore.createWatchlist(form.value)
    router.push({ name: 'watchlists.index' })
  } catch (error) {
    console.error('Failed to create watchlist', error)
  }
}
</script>

<template>
  <div class="flex flex-col gap-3.5 p-4 bg-bg-base min-h-screen">

    <!-- Header -->
    <div class="flex items-center gap-3">
      <router-link
        :to="{ name: 'watchlists.index' }"
        class="flex items-center justify-center w-8 h-8 rounded-chip text-text-ghost hover:bg-bg-hover hover:text-cyan transition-all"
      >
        <ArrowLeft class="h-4 w-4" />
      </router-link>
      <div>
        <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Watchlists</p>
        <h1 class="text-sm font-semibold text-text-primary">New Watchlist</h1>
      </div>
    </div>

    <!-- Form card -->
    <div class="max-w-lg bg-bg-surface border border-border rounded-card p-6">
      <form @submit.prevent="handleSubmit" class="flex flex-col gap-5">

        <!-- Name -->
        <div class="flex flex-col gap-1.5">
          <label for="name" class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">
            Name <span class="text-loss">*</span>
          </label>
          <input
            id="name"
            v-model="form.name"
            type="text"
            required
            placeholder="e.g. Core Swings, High Growth"
            class="w-full bg-bg-elevated border border-border rounded-chip px-3 py-2 font-mono text-sm text-text-primary placeholder:text-text-ghost outline-none focus:border-cyan/40 transition-colors"
          />
        </div>

        <!-- Description -->
        <div class="flex flex-col gap-1.5">
          <label for="description" class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">
            Description
          </label>
          <textarea
            id="description"
            v-model="form.description"
            rows="3"
            placeholder="Describe the strategy or focus of this watchlist..."
            class="w-full bg-bg-elevated border border-border rounded-chip px-3 py-2 font-mono text-sm text-text-primary placeholder:text-text-ghost outline-none focus:border-cyan/40 transition-colors resize-none"
          />
        </div>

        <!-- Set as default -->
        <label class="flex items-center gap-3 cursor-pointer group">
          <div class="relative flex items-center">
            <input
              v-model="form.is_default"
              type="checkbox"
              class="peer h-4 w-4 appearance-none rounded border border-border bg-bg-elevated transition-all checked:border-cyan checked:bg-cyan cursor-pointer"
            />
            <svg
              class="absolute left-0.5 top-0.5 hidden h-3 w-3 pointer-events-none text-bg-base peer-checked:block"
              viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5"
              stroke-linecap="round" stroke-linejoin="round"
            >
              <polyline points="20 6 9 17 4 12" />
            </svg>
          </div>
          <div>
            <p class="text-xs font-semibold text-text-muted group-hover:text-text-primary transition-colors">Set as default</p>
            <p class="font-mono text-[10px] text-text-ghost">Used as the pre-selected watchlist in other views</p>
          </div>
        </label>

        <!-- Actions -->
        <div class="flex items-center gap-3 pt-2 border-t border-border">
          <button
            type="submit"
            :disabled="watchlistStore.loading || !form.name.trim()"
            class="flex items-center gap-2 bg-cyan text-bg-base px-5 py-1.5 rounded-chip font-mono text-[11px] font-bold uppercase tracking-[0.15em] hover:bg-cyan-dim transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
          >
            <span v-if="!watchlistStore.loading">Create Watchlist</span>
            <span v-else class="flex items-center gap-2">
              <svg class="h-3.5 w-3.5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
              </svg>
              Creating...
            </span>
          </button>

          <router-link
            :to="{ name: 'watchlists.index' }"
            class="font-mono text-[11px] text-text-ghost hover:text-text-muted transition-colors"
          >
            Cancel
          </router-link>
        </div>

      </form>
    </div>

  </div>
</template>
