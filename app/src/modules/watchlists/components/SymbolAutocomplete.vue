<script setup>
import { ref, computed, watch, onBeforeUnmount } from 'vue'
import { useWatchlistStore } from '@/modules/watchlists/stores/useWatchlistStore'
import { Search, X } from 'lucide-vue-next'

const props = defineProps({
  modelValue: {
    type: String,
    default: null,
  },
})

const emit = defineEmits(['update:modelValue'])

const watchlistStore = useWatchlistStore()

const query = ref('')
const showDropdown = ref(false)
const debounceId = ref(null)
const selectedItem = ref(null)

const results = computed(() => watchlistStore.symbolsResult ?? [])
const loading = computed(() => watchlistStore.loadingSymbol)

const fetchSymbols = async (q) => {
  const clean = q.trim()
  if (clean.length < 1) return
  await watchlistStore.getBySymbol({ query: clean, limit: 10 })
}

const onInput = () => {
  selectedItem.value = null
  emit('update:modelValue', null)
  showDropdown.value = true

  if (debounceId.value) clearTimeout(debounceId.value)
  debounceId.value = setTimeout(() => fetchSymbols(query.value), 350)
}

const selectItem = (item) => {
  selectedItem.value = item
  query.value = item.ticker
  showDropdown.value = false
  emit('update:modelValue', item.ticker)
}

const clearSelection = () => {
  selectedItem.value = null
  query.value = ''
  showDropdown.value = false
  emit('update:modelValue', null)
  watchlistStore.symbolsResult = []
}

const onBlur = () => {
  setTimeout(() => { showDropdown.value = false }, 150)
}

watch(() => props.modelValue, (val) => {
  if (!val) {
    selectedItem.value = null
    query.value = ''
  }
})

onBeforeUnmount(() => {
  if (debounceId.value) clearTimeout(debounceId.value)
})
</script>

<template>
  <div class="flex flex-col gap-2">
    <!-- Input -->
    <div class="relative">
      <Search class="absolute left-3 top-1/2 -translate-y-1/2 h-3.5 w-3.5 text-text-ghost pointer-events-none" />
      <input
        v-model="query"
        type="text"
        placeholder="Search ticker or name (e.g. AAPL)..."
        class="w-full bg-bg-elevated border border-border rounded-chip pl-9 pr-8 py-2 font-mono text-sm text-text-primary placeholder:text-text-ghost outline-none focus:border-cyan/40 transition-colors"
        @input="onInput"
        @focus="showDropdown = query.length > 0"
        @blur="onBlur"
      />
      <button
        v-if="query"
        @mousedown.prevent="clearSelection"
        class="absolute right-2 top-1/2 -translate-y-1/2 text-text-ghost hover:text-text-muted transition-colors"
      >
        <X class="h-3.5 w-3.5" />
      </button>
    </div>

    <!-- Dropdown -->
    <div
      v-if="showDropdown && (loading || results.length > 0)"
      class="bg-bg-surface border border-border rounded-card shadow-2xl max-h-56 overflow-y-auto"
    >
      <!-- Loading -->
      <div v-if="loading" class="flex items-center gap-2 px-4 py-3 font-mono text-[11px] text-text-ghost">
        <div class="flex gap-1">
          <div class="h-1 w-1 animate-bounce bg-cyan rounded-full" />
          <div class="h-1 w-1 animate-bounce bg-cyan rounded-full [animation-delay:0.15s]" />
          <div class="h-1 w-1 animate-bounce bg-cyan rounded-full [animation-delay:0.3s]" />
        </div>
        Searching...
      </div>

      <!-- Results -->
      <template v-else>
        <button
          v-for="item in results"
          :key="item.ticker"
          @mousedown.prevent="selectItem(item)"
          class="w-full flex items-center justify-between gap-4 px-4 py-2.5 hover:bg-bg-elevated transition-colors text-left"
        >
          <div>
            <p class="font-mono text-sm font-bold text-text-primary">{{ item.ticker }}</p>
            <p class="font-mono text-[10px] text-text-ghost truncate max-w-[200px]">{{ item.name }}</p>
          </div>
          <div class="text-right shrink-0">
            <p class="font-mono text-[10px] font-bold text-cyan/70 uppercase">{{ item.symbol_type }}</p>
            <p class="font-mono text-[10px] text-text-ghost">{{ item.primary_exchange }}</p>
          </div>
        </button>
      </template>
    </div>

    <!-- Selected preview -->
    <div
      v-if="selectedItem"
      class="flex items-center justify-between bg-cyan/5 border border-cyan/20 rounded-chip px-3 py-2"
    >
      <div class="flex items-center gap-2">
        <div class="flex items-center justify-center w-7 h-7 rounded bg-cyan/10 border border-cyan/20 font-mono text-[10px] font-bold text-cyan">
          {{ selectedItem.ticker?.[0] }}
        </div>
        <div>
          <p class="font-mono text-xs font-bold text-text-primary">{{ selectedItem.ticker }}</p>
          <p class="font-mono text-[10px] text-text-ghost">{{ selectedItem.name }}</p>
        </div>
      </div>
      <span class="font-mono text-[10px] text-text-ghost">{{ selectedItem.primary_exchange }}</span>
    </div>
  </div>
</template>
