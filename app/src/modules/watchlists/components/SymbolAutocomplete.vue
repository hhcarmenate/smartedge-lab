<script setup>
import { ref, watch, onBeforeUnmount, computed } from 'vue'
import axios from 'axios'
import BaseAutocomplete from '@/components/BaseAutocomplete.vue'
import { useWatchlistStore } from '@/modules/watchlists/stores/useWatchlistStore'

const props = defineProps({
  modelValue: {
    type: [String, Number, Object],
    default: null,
  },
})

const emit = defineEmits(['update:modelValue'])

const watchlistStore = useWatchlistStore()

const searchQuery = ref('')
const loading = ref(false)
const debounceId = ref(null)

const selectedSymbol = computed(() => {
  return symbols.value.find(symbol => symbol.ticker === props.modelValue) || null
})

const symbols = computed(() => {
  return watchlistStore.symbolsResult ?? []
})

const handleUpdate = (val) => {
  emit('update:modelValue', val)
}

const fetchSymbols = async (query) => {
  const cleanQuery = query.trim()

  if (cleanQuery.length < 1) {
    symbols.value = []
    return
  }

  try {
    loading.value = true
    await watchlistStore.getBySymbol( {query: cleanQuery, limit: 10})
  } catch (error) {
    console.error('Symbol search error:', error)
    symbols.value = []
  } finally {
    loading.value = false
  }
}

watch(searchQuery, (newValue) => {
  if (debounceId.value) {
    clearTimeout(debounceId.value)
  }

  debounceId.value = setTimeout(() => {
    fetchSymbols(newValue)
  }, 350)
})

onBeforeUnmount(() => {
  if (debounceId.value) {
    clearTimeout(debounceId.value)
  }
})
</script>

<template>
  <div class="symbol-autocomplete">
    <BaseAutocomplete
        :model-value="modelValue"
        :items="symbols"
        :loading="loading"
        label="Symbol Selection"
        placeholder="Type ticker or asset name (e.g. AAPL...)"
        item-text="ticker"
        item-value="ticker"
        @update:model-value="handleUpdate"
        @search="searchQuery = $event"
    >
      <template #item="{ item }">
        <div class="flex items-center justify-between gap-4 py-1">
          <div>
            <p class="font-mono text-sm font-black text-white">
              {{ item.ticker }}
            </p>
            <p class="text-xs text-white/50">
              {{ item.name }}
            </p>
          </div>

          <div class="text-right">
            <p class="text-[10px] font-bold uppercase tracking-widest text-accent/70">
              {{ item.symbol_type }}
            </p>
            <p class="text-[10px] text-white/35">
              {{ item.primary_exchange }}
            </p>
          </div>
        </div>
      </template>
    </BaseAutocomplete>

    <div
        v-if="selectedSymbol"
        class="mt-4 rounded-xl border border-accent/10 bg-accent/5 p-4 transition-all animate-in fade-in slide-in-from-top-2"
    >
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="flex h-10 w-10 items-center justify-center rounded-lg border border-accent/20 bg-black font-mono text-xs font-black text-accent shadow-glow">
            {{ selectedSymbol.ticker?.[0] }}
          </div>

          <div>
            <p class="font-mono text-[10px] font-bold uppercase tracking-widest text-accent/60">
              Selected Asset
            </p>
            <h4 class="text-sm font-black text-white">
              {{ selectedSymbol.ticker }}
            </h4>
            <p class="text-xs text-white/45">
              {{ selectedSymbol.name }}
            </p>
          </div>
        </div>

        <div class="text-right">
          <p class="font-mono text-[10px] font-bold uppercase tracking-widest text-white/30">
            Exchange
          </p>
          <p class="text-[10px] font-bold uppercase text-success">
            {{ selectedSymbol.primary_exchange || 'N/A' }}
          </p>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.shadow-glow {
  box-shadow: 0 0 15px rgba(255, 138, 0, 0.15);
}
</style>
