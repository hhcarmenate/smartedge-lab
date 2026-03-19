<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useWatchlistStore } from '@/modules/watchlists/stores/useWatchlistStore'
import PanelCard from '@/components/ui/PanelCard.vue'
import AppBadge from '@/components/ui/AppBadge.vue'
import SymbolModal from '../components/SymbolModal.vue'
import DeleteSymbolModal from '../components/DeleteSymbolModal.vue'
import DeleteWatchlistModal from '../components/DeleteWatchlistModal.vue'
import { ArrowLeft, Plus, Trash2 } from 'lucide-vue-next'

const route = useRoute()
const router = useRouter()
const watchlistStore = useWatchlistStore()

const showSymbolModal = ref(false)
const showDeleteSymbolModal = ref(false)
const showDeleteWatchlistModal = ref(false)
const symbolToDelete = ref(null)

const watchlistId = computed(() => route.params.id)

const openDeleteSymbolModal = (item) => {
  symbolToDelete.value = item
  showDeleteSymbolModal.value = true
}

const handleDeleteSymbolConfirm = async (itemId) => {
  try {
    await watchlistStore.removeSymbolFromWatchlist(itemId)
    showDeleteSymbolModal.value = false
    symbolToDelete.value = null
  } catch (e) {
    console.error('Failed to remove symbol:', e)
  }
}

const handleDeleteWatchlistConfirm = async (id) => {
  try {
    await watchlistStore.deleteWatchlist(id)
    showDeleteWatchlistModal.value = false
    router.push({ name: 'watchlists.index' })
  } catch (e) {
    console.error('Failed to delete watchlist:', e)
  }
}

const handleSymbolConfirm = async (ticker) => {
  try {
    await watchlistStore.addSymbolToWatchlist({ ticker, watchlistId: watchlistId.value })
    showSymbolModal.value = false
  } catch (e) {
    console.error('Failed to add symbol:', e)
  }
}

onMounted(() => {
  watchlistStore.fetchWatchlistById(watchlistId.value)
})

onUnmounted(() => {
  watchlistStore.selectedWatchlist = null
})
</script>

<template>
  <div class="flex flex-col gap-3.5 p-4 bg-bg-base min-h-screen">

    <!-- Header -->
    <div class="flex items-center justify-between">
      <div class="flex items-center gap-3">
        <router-link
          :to="{ name: 'watchlists.index' }"
          class="flex items-center justify-center w-8 h-8 rounded-chip text-text-ghost hover:bg-bg-hover hover:text-cyan transition-all"
        >
          <ArrowLeft class="h-4 w-4" />
        </router-link>
        <div>
          <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Watchlists</p>
          <h1 class="text-sm font-semibold text-text-primary">
            {{ watchlistStore.selectedWatchlist?.name ?? '...' }}
          </h1>
        </div>
      </div>

      <div class="flex items-center gap-2">
        <button
          @click="showDeleteWatchlistModal = true"
          class="flex items-center gap-1.5 h-8 px-3 rounded-chip text-text-ghost border border-border font-mono text-[11px] hover:text-loss hover:border-loss/30 transition-all"
        >
          <Trash2 class="h-3.5 w-3.5" />
          Delete
        </button>
        <button
          @click="showSymbolModal = true"
          class="flex items-center gap-2 bg-cyan text-bg-base px-4 py-1.5 rounded-chip font-mono text-[11px] font-bold uppercase tracking-[0.15em] hover:bg-cyan-dim transition-colors"
        >
          <Plus class="h-3.5 w-3.5" />
          Add Symbol
        </button>
      </div>
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

    <template v-else-if="watchlistStore.selectedWatchlist">
      <p v-if="watchlistStore.selectedWatchlist.description" class="text-xs text-text-ghost px-1">
        {{ watchlistStore.selectedWatchlist.description }}
      </p>

      <!-- Symbols table -->
      <PanelCard>
        <template #header>Symbols</template>
        <template #actions>
          <AppBadge variant="cyan" :label="`${watchlistStore.selectedWatchlist.items?.length ?? 0} SYMBOLS`" />
        </template>

        <div v-if="watchlistStore.selectedWatchlist.items?.length">
          <table class="w-full text-left">
            <thead>
              <tr class="border-b border-border/60">
                <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Ticker</th>
                <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Name</th>
                <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Exchange</th>
                <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost">Added</th>
                <th class="px-4 py-2.5 font-mono text-[10px] uppercase tracking-widest text-text-ghost text-right">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="item in watchlistStore.selectedWatchlist.items"
                :key="item.id"
                class="border-b border-border/40 hover:bg-bg-elevated transition-colors duration-100 group"
              >
                <td class="px-4 py-3.5">
                  <span class="font-mono text-sm font-bold text-text-primary group-hover:text-cyan transition-colors">
                    {{ item.symbol?.ticker }}
                  </span>
                </td>
                <td class="px-4 py-3.5">
                  <span class="text-[12px] text-text-muted">{{ item.symbol?.name ?? '—' }}</span>
                </td>
                <td class="px-4 py-3.5">
                  <span class="font-mono text-[11px] text-text-ghost">{{ item.symbol?.primary_exchange ?? '—' }}</span>
                </td>
                <td class="px-4 py-3.5">
                  <span class="font-mono text-[11px] text-text-ghost">
                    {{ new Date(item.created_at).toLocaleDateString() }}
                  </span>
                </td>
                <td class="px-4 py-3.5 text-right">
                  <button
                    @click="openDeleteSymbolModal(item)"
                    class="opacity-0 group-hover:opacity-100 inline-flex items-center gap-1.5 font-mono text-[10px] text-text-ghost hover:text-loss border border-border rounded px-2 py-1 ml-auto hover:border-loss/30 transition-all"
                  >
                    <Trash2 class="h-3 w-3" />
                    Remove
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Empty -->
        <div v-else class="flex flex-col items-center justify-center py-16 gap-3">
          <p class="text-sm text-text-muted">No symbols in this watchlist</p>
          <button
            @click="showSymbolModal = true"
            class="flex items-center gap-2 bg-cyan text-bg-base px-4 py-1.5 rounded-chip font-mono text-[11px] font-bold uppercase tracking-[0.15em] hover:bg-cyan-dim transition-colors"
          >
            <Plus class="h-3.5 w-3.5" />
            Add Symbol
          </button>
        </div>
      </PanelCard>
    </template>

    <!-- Not found -->
    <div v-else-if="!watchlistStore.loading" class="flex flex-col items-center justify-center py-24 gap-3">
      <p class="text-sm text-text-muted">Watchlist not found</p>
      <router-link :to="{ name: 'watchlists.index' }" class="font-mono text-[11px] text-cyan hover:text-cyan-dim">
        Back to watchlists
      </router-link>
    </div>

  </div>

  <SymbolModal
    :show="showSymbolModal"
    :loading="watchlistStore.loadingAdd"
    @close="showSymbolModal = false"
    @confirm="handleSymbolConfirm"
  />
  <DeleteSymbolModal
    :show="showDeleteSymbolModal"
    :symbol="symbolToDelete"
    :loading="watchlistStore.loadingRemove"
    @close="showDeleteSymbolModal = false"
    @confirm="handleDeleteSymbolConfirm"
  />
  <DeleteWatchlistModal
    :show="showDeleteWatchlistModal"
    :watchlist="watchlistStore.selectedWatchlist"
    :loading="watchlistStore.loading"
    @close="showDeleteWatchlistModal = false"
    @confirm="handleDeleteWatchlistConfirm"
  />
</template>
