<script setup>
import { ref } from 'vue'
import BaseModal from '@/components/BaseModal.vue'
import BaseButton from '@/components/BaseButton.vue'
import SymbolAutocomplete from './SymbolAutocomplete.vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['close', 'confirm'])

const selectedSymbol = ref(null)

const handleClose = () => {
  selectedSymbol.value = null
  emit('close')
}

const handleConfirm = () => {
  if (selectedSymbol.value) {
    emit('confirm', selectedSymbol.value)
    handleClose()
  }
}
</script>

<template>
  <BaseModal
    :show="show"
    title="Allocate Market Asset"
    max-width="max-w-md"
    @close="handleClose"
  >
    <div class="space-y-6">
      <div class="flex items-center gap-4 rounded-2xl border border-white/5 bg-white/[0.02] p-4">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-white/10 bg-black text-xl shadow-inner">🛰️</div>
        <div class="space-y-1">
          <h4 class="font-mono text-[10px] font-bold uppercase tracking-[0.2em] text-white/40">Operation Mode</h4>
          <p class="text-xs font-medium text-text-secondary leading-relaxed">
            Search and select a new asset ticker to synchronize with your terminal watchlist.
          </p>
        </div>
      </div>

      <SymbolAutocomplete v-model="selectedSymbol" />

      <div class="rounded-xl border border-dashed border-white/10 p-4">
        <div class="flex items-center gap-3">
          <div class="h-1.5 w-1.5 rounded-full bg-accent/40"></div>
          <span class="font-mono text-[9px] font-bold uppercase tracking-widest text-white/30">Auto-validation active</span>
        </div>
      </div>
    </div>

    <template #footer>
      <BaseButton
        variant="ghost"
        @click="handleClose"
      >
        Abort
      </BaseButton>
      <BaseButton
        @click="handleConfirm"
        :disabled="!selectedSymbol"
      >
        <span>Confirm Allocation</span>
        <template #icon>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"></polyline></svg>
        </template>
      </BaseButton>
    </template>
  </BaseModal>
</template>

<style scoped>
.shadow-glow {
  box-shadow: 0 0 20px rgba(255, 138, 0, 0.25);
}
</style>
