<script setup>
import { ref, computed, onMounted, onUnmounted, watch } from 'vue'

const props = defineProps({
  modelValue: {
    type: [String, Number, Object],
    default: null
  },
  items: {
    type: Array,
    default: () => []
  },
  placeholder: {
    type: String,
    default: 'Search...'
  },
  label: {
    type: String,
    default: ''
  },
  itemText: {
    type: String,
    default: 'name'
  },
  itemValue: {
    type: String,
    default: 'id'
  },
  loading: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['update:modelValue', 'search'])

const searchQuery = ref('')
const isOpen = ref(false)
const highlightedIndex = ref(-1)
const containerRef = ref(null)

// Si tenemos un valor inicial, intentamos encontrar el texto correspondiente
watch(() => props.modelValue, (newVal) => {
  if (newVal === null || newVal === undefined) {
    searchQuery.value = ''
    return
  }

  const selectedItem = props.items.find(item =>
    (typeof item === 'object' ? item[props.itemValue] : item) === newVal
  )

  if (selectedItem) {
    searchQuery.value = typeof selectedItem === 'object' ? selectedItem[props.itemText] : selectedItem
  }
}, { immediate: true })

const filteredItems = computed(() => {
  if (!searchQuery.value || props.modelValue) {
    // Si hay un valor seleccionado y coincide con la query, mostramos todo o nada según lógica deseada
    // Para un autocomplete genérico, solemos mostrar filtrados si el usuario borra y escribe
  }

  const query = searchQuery.value.toLowerCase()
  return props.items.filter(item => {
    const text = typeof item === 'object' ? item[props.itemText] : item
    return text.toString().toLowerCase().includes(query)
  })
})

const selectItem = (item) => {
  const value = typeof item === 'object' ? item[props.itemValue] : item
  const text = typeof item === 'object' ? item[props.itemText] : item

  searchQuery.value = text
  emit('update:modelValue', value)
  isOpen.value = false
  highlightedIndex.value = -1
}

const handleInput = (e) => {
  searchQuery.value = e.target.value
  emit('update:modelValue', null) // Reset value while typing
  emit('search', searchQuery.value)
  isOpen.value = true
  highlightedIndex.value = 0
}

const onFocus = () => {
  if (!props.disabled) {
    isOpen.value = true
  }
}

const handleClickOutside = (event) => {
  if (containerRef.value && !containerRef.value.contains(event.target)) {
    isOpen.value = false
  }
}

const moveHighlight = (direction) => {
  if (!isOpen.value) {
    isOpen.value = true
    return
  }

  const count = filteredItems.value.length
  if (count === 0) return

  highlightedIndex.value = (highlightedIndex.value + direction + count) % count
}

const selectHighlighted = () => {
  if (highlightedIndex.value >= 0 && highlightedIndex.value < filteredItems.value.length) {
    selectItem(filteredItems.value[highlightedIndex.value])
  }
}

onMounted(() => {
  document.addEventListener('click', handleClickOutside)
})

onUnmounted(() => {
  document.removeEventListener('click', handleClickOutside)
})
</script>

<template>
  <div ref="containerRef" class="relative w-full space-y-3">
    <label
      v-if="label"
      class="ml-1 font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-white/60"
    >
      {{ label }}
    </label>

    <div class="relative group">
      <!-- Icon/Indicator -->
      <div class="absolute left-5 top-1/2 -translate-y-1/2 z-10">
        <div v-if="loading" class="h-4 w-4 animate-spin rounded-full border-2 border-accent/20 border-t-accent"></div>
        <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white/20 group-focus-within:text-accent transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>

      <input
        type="text"
        :value="searchQuery"
        :placeholder="placeholder"
        :disabled="disabled"
        @input="handleInput"
        @focus="onFocus"
        @keydown.down.prevent="moveHighlight(1)"
        @keydown.up.prevent="moveHighlight(-1)"
        @keydown.enter.prevent="selectHighlighted"
        @keydown.esc="isOpen = false"
        class="w-full rounded-2xl border border-white/12 bg-[linear-gradient(180deg,rgba(17,17,19,0.98),rgba(11,11,12,1))] pl-12 pr-5 py-4 text-sm text-white placeholder:text-white/20 outline-none transition-all duration-300 focus:border-accent/35 focus:bg-accent/[0.04] focus:shadow-[0_0_0_1px_rgba(255,138,0,0.15),0_0_24px_rgba(255,138,0,0.10)] disabled:opacity-50 disabled:cursor-not-allowed"
      />

      <!-- Dropdown -->
      <Transition
        enter-active-class="transition duration-200 ease-out"
        enter-from-class="opacity-0 translate-y-2 scale-95"
        enter-to-class="opacity-100 translate-y-0 scale-100"
        leave-active-class="transition duration-150 ease-in"
        leave-from-class="opacity-100 translate-y-0 scale-100"
        leave-to-class="opacity-0 translate-y-2 scale-95"
      >
        <div
          v-if="isOpen && (filteredItems.length > 0 || loading)"
          class="absolute z-50 mt-3 w-full overflow-hidden rounded-[24px] border border-white/10 bg-[linear-gradient(180deg,rgba(14,14,15,0.98),rgba(6,6,7,1))] p-1 shadow-[0_20px_50px_rgba(0,0,0,0.5)] backdrop-blur-md"
        >
          <div class="max-h-[280px] overflow-y-auto custom-scrollbar">
            <div v-if="loading" class="p-4 text-center">
               <span class="font-mono text-[10px] font-bold uppercase tracking-widest text-accent/60">Searching Database...</span>
            </div>

            <ul v-else-if="filteredItems.length > 0" class="p-1">
              <li
                v-for="(item, index) in filteredItems"
                :key="index"
                @click="selectItem(item)"
                @mouseenter="highlightedIndex = index"
                class="relative flex cursor-pointer items-center justify-between rounded-xl px-4 py-3.5 transition-all duration-200"
                :class="[
                  highlightedIndex === index
                    ? 'bg-accent/10 text-accent shadow-[inset_0_0_0_1px_rgba(255,138,0,0.2)]'
                    : 'text-text-secondary hover:bg-white/[0.03] hover:text-white'
                ]"
              >
                <span class="text-sm font-medium tracking-tight">
                  {{ typeof item === 'object' ? item[itemText] : item }}
                </span>

                <div
                  v-if="highlightedIndex === index"
                  class="flex items-center gap-2"
                >
                  <span class="font-mono text-[9px] font-bold uppercase tracking-tighter text-accent/50">Select</span>
                  <div class="h-1.5 w-1.5 rounded-full bg-accent shadow-[0_0_8px_rgba(255,138,0,0.5)]"></div>
                </div>
              </li>
            </ul>
          </div>

          <!-- Decorative bottom gradient -->
          <div class="h-px w-full bg-gradient-to-r from-transparent via-accent/30 to-transparent"></div>
        </div>
      </Transition>
    </div>
  </div>
</template>

<style scoped>
.custom-scrollbar::-webkit-scrollbar {
  width: 4px;
}
.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.05);
  border-radius: 10px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 138, 0, 0.2);
}
</style>
