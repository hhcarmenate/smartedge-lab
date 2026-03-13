<script setup>
import {computed, onMounted, onUnmounted, ref} from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { useWatchlistStore } from '@/modules/watchlists/stores/useWatchlistStore'
import BaseButton from '@/components/BaseButton.vue'
import SymbolModal from '../components/SymbolModal.vue'
import DeleteSymbolModal from '../components/DeleteSymbolModal.vue'
import DeleteWatchlistModal from '../components/DeleteWatchlistModal.vue'

const route = useRoute()
const router = useRouter()
const watchlistStore = useWatchlistStore()
const showSymbolModal = ref(false)
const showDeleteModal = ref(false)
const showDeleteWatchlistModal = ref(false)
const symbolToDelete = ref(null)
const deleting = ref(false)
const deletingWatchlist = ref(false)

const openDeleteModal = (item) => {
  symbolToDelete.value = item
  showDeleteModal.value = true
}

const handleDeleteConfirm = async (itemId) => {
  deleting.value = true
  try {
    await watchlistStore.removeSymbolFromWatchlist(itemId)
    showDeleteModal.value = false
    symbolToDelete.value = null
  } catch (e) {
    console.error('Failed to remove symbol:', e)
  } finally {
    deleting.value = false
  }
}

const handleDeleteWatchlistConfirm = async (id) => {
  deletingWatchlist.value = true
  try {
    await watchlistStore.deleteWatchlist(id)
    showDeleteWatchlistModal.value = false
    router.push({ name: 'watchlists.index' })
  } catch (e) {
    console.error('Failed to delete watchlist:', e)
  } finally {
    deletingWatchlist.value = false
  }
}

const handleSymbolConfirm = async (ticker) => {
  try {
    await watchlistStore.addSymbolToWatchlist({
      ticker: ticker,
      watchlistId: watchListId.value
    })

    await watchlistStore.fetchWatchlistById(watchListId.value)

  } catch (e) {
    console.log(e)
  }
}

const watchListId = computed(() => route.params.id)

onMounted(() => {
  watchlistStore.fetchWatchlistById(watchListId.value)
})

onUnmounted(() => {
  watchlistStore.selectedWatchlist = null
})
</script>

<template>
  <section class="p-6 xl:p-8 space-y-12">
    <header v-if="watchlistStore.selectedWatchlist" class="relative flex items-end justify-between overflow-hidden rounded-[30px] border border-accent/20 bg-[linear-gradient(180deg,rgba(14,14,15,0.98),rgba(6,6,7,1))] p-10 shadow-[0_18px_55px_rgba(0,0,0,0.45)]">
      <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/60 to-transparent"></div>
      <div class="absolute right-0 top-0 h-48 w-48 rounded-full bg-accent/10 blur-[90px]"></div>

      <div class="relative z-10">
        <div class="mb-4 flex items-center gap-3 font-mono text-[10px] font-bold uppercase tracking-[0.4em]">
          <RouterLink :to="{ name: 'watchlists.index' }" class="text-white/40 hover:text-accent transition-colors">
            Watchlists
          </RouterLink>
          <span class="text-white/10">/</span>
          <span class="text-accent">Terminal Detail</span>
        </div>
        <h1 class="text-4xl font-black tracking-tight text-white md:text-5xl">
          {{ watchlistStore.selectedWatchlist.name }}
        </h1>
        <p class="mt-4 max-w-2xl text-sm font-medium leading-relaxed text-text-secondary">
          {{ watchlistStore.selectedWatchlist.description || 'Professional trading watchlist without description.' }}
          <span class="block mt-1 text-white/50">Active monitoring session in progress.</span>
        </p>
      </div>

      <div class="relative z-10 flex items-center gap-4">
        <BaseButton
            variant="danger"
            @click="showDeleteWatchlistModal = true"
            title="Terminate Watchlist"
        >
          <template #icon>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/></svg>
          </template>
        </BaseButton>
        <BaseButton
            variant="outline"
            @click="$router.push({ name: 'watchlists.index' })"
        >
          Back to List
        </BaseButton>
        <BaseButton
            @click="showSymbolModal = true"
        >
          <span>Manage Symbols</span>
          <template #icon>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20v-6M9 20v-10M6 20v-4M15 20v-8M18 20v-12"/></svg>
          </template>
        </BaseButton>
      </div>
    </header>

    <div v-if="watchlistStore.loading" class="flex items-center gap-4 px-4 font-mono text-xs tracking-widest text-accent/60">
      <div class="flex gap-1">
        <div class="h-1 w-1 animate-bounce bg-accent rounded-full"></div>
        <div class="h-1 w-1 animate-bounce bg-accent rounded-full [animation-delay:0.2s]"></div>
        <div class="h-1 w-1 animate-bounce bg-accent rounded-full [animation-delay:0.4s]"></div>
      </div>
      Loading terminal matrix...
    </div>

    <template v-else-if="watchlistStore.selectedWatchlist">
      <div class="grid gap-10">
        <!-- Main Data Table Container -->
        <div class="relative overflow-hidden rounded-[28px] border border-white/10 bg-[linear-gradient(180deg,rgba(14,14,15,0.98),rgba(6,6,7,1))] shadow-[0_18px_55px_rgba(0,0,0,0.45)]">
          <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent group-hover:via-accent/50 transition-all duration-500"></div>

          <div class="relative z-10">
            <div class="flex items-center justify-between border-b border-white/5 bg-white/[0.02] p-8">
              <div class="flex items-center gap-3">
                <div class="h-3 w-1 rounded-full bg-accent shadow-glow"></div>
                <h3 class="font-mono text-[10px] font-bold uppercase tracking-[0.35em] text-accent">Market Assets</h3>
              </div>
              <div class="flex items-center gap-4">
                <span class="rounded-xl border border-accent/25 bg-accent-soft px-4 py-2 font-mono text-[10px] font-black uppercase tracking-[0.15em] text-accent">
                  {{ watchlistStore.selectedWatchlist.items?.length || 0 }} ALLOCATED
                </span>
              </div>
            </div>

            <div class="min-h-[400px]">
              <div
                  v-if="watchlistStore.selectedWatchlist.items?.length"
                  class="overflow-x-auto"
              >
                <table class="w-full text-left border-collapse">
                  <thead>
                    <tr class="border-b border-white/5 bg-white/[0.01]">
                      <th class="px-10 py-6 font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-white/30">Ticker Symbol</th>
                      <th class="px-10 py-6 font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-white/30">Added Timestamp</th>
                      <th class="px-10 py-6 font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-white/30">Status</th>
                      <th class="px-10 py-6 font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-white/30 text-right">Operations</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-white/[0.03]">
                    <tr
                        v-for="item in watchlistStore.selectedWatchlist.items"
                        :key="item.id"
                        class="group/row transition-all duration-300 hover:bg-white/[0.02]"
                    >
                      <td class="px-10 py-8">
                        <div class="flex items-center gap-4">
                          <span class="text-xl font-black tracking-tight text-white group-hover/row:text-accent transition-colors">
                            {{ item.symbol?.ticker ?? '' }}
                          </span>
                        </div>
                      </td>
                      <td class="px-10 py-8">
                        <div class="flex flex-col gap-1">
                          <span class="font-mono text-xs font-bold text-white/60">
                            {{ new Date(item.created_at).toLocaleDateString() }}
                          </span>
                          <span class="font-mono text-[10px] text-white/30 uppercase tracking-widest">
                            {{ new Date(item.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) }}
                          </span>
                        </div>
                      </td>
                      <td class="px-10 py-8">
                        <div class="inline-flex items-center gap-2.5 rounded-full border border-success/20 bg-success/5 px-4 py-1.5 text-[10px] font-black uppercase tracking-widest text-success">
                          <div class="h-1.5 w-1.5 animate-pulse rounded-full bg-success shadow-[0_0_8px_rgba(16,185,129,0.8)]"></div>
                          Tracking
                        </div>
                      </td>
                      <td class="px-10 py-8 text-right">
                        <button
                            @click="openDeleteModal(item)"
                            class="cursor-pointer group/btn flex items-center justify-center gap-2 ml-auto font-mono text-[10px] font-bold uppercase tracking-[0.2em] text-white/20 transition-all hover:text-danger"
                            title="Remove Asset"
                        >
                          <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 transition-transform group-hover/btn:scale-110" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/>
                          </svg>
                          <span>Remove</span>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <div
                  v-else
                  class="flex flex-col items-center justify-center py-32 text-center"
              >
                <div class="relative mb-8 flex h-24 w-24 items-center justify-center rounded-full border border-white/5 bg-white/[0.02]">
                  <div class="absolute inset-0 rounded-full bg-accent/5 blur-2xl"></div>
                  <span class="text-4xl grayscale opacity-30">📉</span>
                </div>
                <h4 class="text-xl font-black tracking-tight text-white">Empty Workspace</h4>
                <p class="mt-4 max-w-xs text-sm font-medium leading-relaxed text-text-secondary">No symbols have been assigned to this terminal yet.</p>
                <BaseButton
                    variant="outline"
                    size="lg"
                    @click="showSymbolModal = true"
                    class="mt-10 !bg-gradient-to-r !from-accent/20 !to-accent/5 !border-accent/30 !text-accent hover:!border-accent/50 hover:!from-accent/30 hover:!to-accent/10"
                >
                  Allocate First Symbol
                </BaseButton>
              </div>
            </div>
          </div>
        </div>

        <!-- Secondary Configuration Panel -->
        <div class="rounded-[28px] border border-dashed border-white/10 bg-white/[0.02] p-10 transition-all hover:bg-white/[0.04]">
           <div class="flex flex-wrap items-center justify-between gap-8">
             <div class="flex items-center gap-8">
               <div class="flex h-16 w-16 items-center justify-center rounded-[22px] border border-white/10 bg-black text-2xl shadow-soft">⚡</div>
               <div class="space-y-1">
                 <h3 class="font-mono text-[10px] font-bold uppercase tracking-[0.35em] text-white/40">Execution Layer</h3>
                 <p class="text-sm font-medium text-text-secondary">Quick allocation and order routing will be available here.</p>
               </div>
             </div>
             <div class="flex h-14 w-72 items-center justify-center rounded-2xl border border-white/10 bg-black font-mono text-[10px] font-bold uppercase tracking-[0.25em] text-white/25">
               <span class="flex items-center gap-3">
                 <span class="h-1 w-1 animate-pulse rounded-full bg-accent"></span>
                 Channel Synchronizing...
               </span>
             </div>
           </div>
        </div>
      </div>
    </template>

    <div
        v-else-if="!watchlistStore.loading"
        class="rounded-lg border border-danger/20 bg-danger/soft p-8 text-center"
    >
      <p class="text-sm text-danger">
        Watchlist not found.
      </p>
      <RouterLink :to="{ name: 'watchlists.index' }" class="mt-4 inline-block text-sm text-text-primary underline">
        Go back to watchlists
      </RouterLink>
    </div>
  </section>

  <SymbolModal
    :show="showSymbolModal"
    @close="showSymbolModal = false"
    @confirm="handleSymbolConfirm"
  />

  <DeleteSymbolModal
    :show="showDeleteModal"
    :symbol="symbolToDelete"
    :loading="deleting"
    @close="showDeleteModal = false"
    @confirm="handleDeleteConfirm"
  />

  <DeleteWatchlistModal
    :show="showDeleteWatchlistModal"
    :watchlist="watchlistStore.selectedWatchlist"
    :loading="deletingWatchlist"
    @close="showDeleteWatchlistModal = false"
    @confirm="handleDeleteWatchlistConfirm"
  />
</template>
