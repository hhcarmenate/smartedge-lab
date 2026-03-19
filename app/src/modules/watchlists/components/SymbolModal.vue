<script setup>
import { ref, watch } from 'vue'
import { X, Plus } from 'lucide-vue-next'
import SymbolAutocomplete from './SymbolAutocomplete.vue'

const props = defineProps({
  show: { type: Boolean, default: false },
  loading: { type: Boolean, default: false },
})

const emit = defineEmits(['close', 'confirm'])

const selectedTicker = ref(null)

const handleClose = () => {
  emit('close')
}

const handleConfirm = () => {
  if (selectedTicker.value && !props.loading) {
    emit('confirm', selectedTicker.value)
  }
}

watch(() => props.show, (val) => {
  if (!val) selectedTicker.value = null
})
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-150"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-100"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="handleClose" />

        <!-- Modal -->
        <div class="relative z-10 w-full max-w-md mx-4 bg-bg-surface border border-border rounded-card shadow-2xl">

          <!-- Header -->
          <div class="flex items-center justify-between px-5 py-4 border-b border-border">
            <div class="flex items-center gap-2">
              <Plus class="h-4 w-4 text-cyan" />
              <h2 class="text-sm font-semibold text-text-primary">Add Symbol</h2>
            </div>
            <button
              @click="handleClose"
              class="flex items-center justify-center w-7 h-7 rounded-chip text-text-ghost hover:bg-bg-hover hover:text-text-primary transition-all"
            >
              <X class="h-4 w-4" />
            </button>
          </div>

          <!-- Body -->
          <div class="p-5">
            <SymbolAutocomplete v-model="selectedTicker" />
          </div>

          <!-- Footer -->
          <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-border">
            <button
              @click="handleClose"
              class="h-8 px-3 rounded-chip font-mono text-[11px] text-text-ghost border border-border hover:text-text-muted hover:border-border-strong transition-all"
            >
              Cancel
            </button>
            <button
              @click="handleConfirm"
              :disabled="!selectedTicker || loading"
              class="flex items-center gap-2 h-8 px-4 bg-cyan text-bg-base rounded-chip font-mono text-[11px] font-bold uppercase tracking-[0.15em] hover:bg-cyan-dim transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg v-if="loading" class="h-3 w-3 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
              </svg>
              {{ loading ? 'Adding...' : 'Add Symbol' }}
            </button>
          </div>

        </div>
      </div>
    </Transition>
  </Teleport>
</template>
