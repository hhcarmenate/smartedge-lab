<script setup>
import { onMounted } from 'vue'
import { useWatchlistStore } from '@/modules/watchlists/stores/useWatchlistStore'
import PanelCard from '@/components/ui/PanelCard.vue'
import AppBadge from '@/components/ui/AppBadge.vue'
import { List, Plus, ChevronRight } from 'lucide-vue-next'

const watchlistStore = useWatchlistStore()

onMounted(() => {
  watchlistStore.fetchWatchlists()
})
</script>

<template>
  <div class="flex flex-col gap-3.5 p-4 bg-bg-base min-h-screen">

    <!-- Header -->
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-2">
        <List class="h-4 w-4 text-cyan" />
        <h1 class="text-sm font-semibold text-text-primary">Watchlists</h1>
      </div>
      <router-link
        :to="{ name: 'watchlists.create' }"
        class="flex items-center gap-2 bg-cyan text-bg-base px-4 py-1.5 rounded-chip font-mono text-[11px] font-bold uppercase tracking-[0.15em] hover:bg-cyan-dim transition-colors"
      >
        <Plus class="h-3.5 w-3.5" />
        New Watchlist
      </router-link>
    </div>

    <!-- Loading -->
    <div v-if="watchlistStore.loading" class="flex items-center gap-2 font-mono text-[11px] text-text-ghost px-1">
      <div class="flex gap-1">
        <div class="h-1 w-1 animate-bounce bg-cyan rounded-full" />
        <div class="h-1 w-1 animate-bounce bg-cyan rounded-full [animation-delay:0.15s]" />
        <div class="h-1 w-1 animate-bounce bg-cyan rounded-full [animation-delay:0.3s]" />
      </div>
      Loading...
    </div>

    <!-- Grid -->
    <div v-else-if="watchlistStore.watchlists.length" class="grid grid-cols-3 gap-3.5">
      <router-link
        v-for="wl in watchlistStore.watchlists"
        :key="wl.id"
        :to="{ name: 'watchlists.show', params: { id: wl.id } }"
        class="group bg-bg-surface border border-border rounded-card p-5 hover:border-cyan/30 transition-all duration-150 flex flex-col gap-4"
      >
        <div class="flex items-start justify-between gap-3">
          <div class="min-w-0">
            <p class="font-semibold text-text-primary group-hover:text-cyan transition-colors truncate">{{ wl.name }}</p>
            <p v-if="wl.description" class="text-xs text-text-ghost mt-0.5 line-clamp-1">{{ wl.description }}</p>
          </div>
          <AppBadge variant="cyan" :label="`${wl.items?.length ?? 0}`" />
        </div>

        <!-- Tickers preview -->
        <div class="flex flex-wrap gap-1.5">
          <span
            v-for="item in (wl.items ?? []).slice(0, 5)"
            :key="item.id"
            class="font-mono text-[10px] font-bold text-text-muted border border-border rounded px-1.5 py-0.5 group-hover:border-cyan/20 group-hover:text-cyan transition-colors"
          >
            {{ item.symbol?.ticker }}
          </span>
          <span
            v-if="(wl.items?.length ?? 0) > 5"
            class="font-mono text-[10px] text-text-ghost px-1"
          >
            +{{ wl.items.length - 5 }}
          </span>
          <span v-if="!(wl.items?.length)" class="font-mono text-[10px] italic text-text-ghost">No symbols yet</span>
        </div>

        <div class="flex items-center justify-between mt-auto pt-3 border-t border-border">
          <span class="font-mono text-[10px] text-text-ghost">{{ wl.items?.length ?? 0 }} symbols</span>
          <ChevronRight class="h-3.5 w-3.5 text-text-ghost group-hover:text-cyan transition-colors" />
        </div>
      </router-link>
    </div>

    <!-- Empty state -->
    <div v-else class="flex flex-col items-center justify-center py-24 gap-4">
      <List class="h-10 w-10 text-text-ghost" />
      <div class="text-center">
        <p class="text-sm font-medium text-text-muted">No watchlists yet</p>
        <p class="text-xs text-text-ghost mt-1">Create one to start organizing your symbols</p>
      </div>
      <router-link
        :to="{ name: 'watchlists.create' }"
        class="flex items-center gap-2 bg-cyan text-bg-base px-4 py-1.5 rounded-chip font-mono text-[11px] font-bold uppercase tracking-[0.15em] hover:bg-cyan-dim transition-colors mt-2"
      >
        <Plus class="h-3.5 w-3.5" />
        Create Watchlist
      </router-link>
    </div>

  </div>
</template>
