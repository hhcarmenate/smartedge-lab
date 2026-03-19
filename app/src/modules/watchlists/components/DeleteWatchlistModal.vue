<script setup>
import { X, Trash2, AlertTriangle } from 'lucide-vue-next'

const props = defineProps({
  show: { type: Boolean, default: false },
  watchlist: { type: Object, default: null },
  loading: { type: Boolean, default: false },
})

const emit = defineEmits(['close', 'confirm'])

const handleConfirm = () => {
  if (!props.watchlist?.id || props.loading) return
  emit('confirm', props.watchlist.id)
}
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
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="emit('close')" />

        <!-- Modal -->
        <div class="relative z-10 w-full max-w-sm mx-4 bg-bg-surface border border-border rounded-card shadow-2xl">

          <!-- Header -->
          <div class="flex items-center justify-between px-5 py-4 border-b border-border">
            <div class="flex items-center gap-2">
              <AlertTriangle class="h-4 w-4 text-loss" />
              <h2 class="text-sm font-semibold text-text-primary">Delete Watchlist</h2>
            </div>
            <button
              @click="emit('close')"
              class="flex items-center justify-center w-7 h-7 rounded-chip text-text-ghost hover:bg-bg-hover hover:text-text-primary transition-all"
            >
              <X class="h-4 w-4" />
            </button>
          </div>

          <!-- Body -->
          <div class="px-5 py-5 space-y-4">
            <p class="text-sm text-text-muted">
              Permanently delete
              <span class="font-mono font-bold text-text-primary">{{ watchlist?.name }}</span>?
            </p>
            <p class="font-mono text-[10px] text-text-ghost">All symbols in this watchlist will be removed. This cannot be undone.</p>
          </div>

          <!-- Footer -->
          <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-border">
            <button
              @click="emit('close')"
              class="h-8 px-3 rounded-chip font-mono text-[11px] text-text-ghost border border-border hover:text-text-muted hover:border-border-strong transition-all"
            >
              Cancel
            </button>
            <button
              @click="handleConfirm"
              :disabled="loading"
              class="flex items-center gap-1.5 h-8 px-4 bg-loss text-white rounded-chip font-mono text-[11px] font-bold uppercase tracking-[0.15em] hover:opacity-90 transition-opacity disabled:opacity-50 disabled:cursor-not-allowed"
            >
              <svg v-if="loading" class="h-3 w-3 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
              </svg>
              <Trash2 v-else class="h-3 w-3" />
              {{ loading ? 'Deleting...' : 'Delete' }}
            </button>
          </div>

        </div>
      </div>
    </Transition>
  </Teleport>
</template>
