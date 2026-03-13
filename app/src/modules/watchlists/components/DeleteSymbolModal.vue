<script setup>
import BaseModal from '@/components/BaseModal.vue'
import BaseButton from '@/components/BaseButton.vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  symbol: {
    type: Object,
    default: null
  },
  loading: {
    type: Boolean,
    default: false
  }
})

const emit = defineEmits(['close', 'confirm'])

const handleClose = () => {
  emit('close')
}

const handleConfirm = async () => {
  if (!props.symbol?.id) return
  emit('confirm', props.symbol.id)
}
</script>

<template>
  <BaseModal
    :show="show"
    title="Disconnect Market Asset"
    max-width="max-w-md"
    @close="handleClose"
  >
    <div class="space-y-6">
      <div class="flex items-center gap-4 rounded-2xl border border-danger/10 bg-danger/5 p-4">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-danger/20 bg-black text-xl shadow-inner">⚠️</div>
        <div class="space-y-1">
          <h4 class="font-mono text-[10px] font-bold uppercase tracking-[0.2em] text-danger/60">Warning: Terminal Separation</h4>
          <p class="text-xs font-medium text-text-secondary leading-relaxed">
            You are about to disconnect <span class="font-black text-white underline decoration-danger/40">{{ symbol?.symbol?.ticker }}</span> from this terminal instance.
          </p>
        </div>
      </div>

      <div class="rounded-xl border border-dashed border-white/10 p-5 bg-white/[0.01]">
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <span class="font-mono text-[9px] font-bold uppercase tracking-widest text-white/20">Target Asset</span>
            <span class="font-mono text-xs font-black text-accent">{{ symbol?.symbol?.ticker }}</span>
          </div>
          <div class="h-px bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>
          <p class="text-[11px] font-medium leading-relaxed text-white/40 italic">
            "Real-time data streams and historical synchronization for this ticker will be suspended immediately upon confirmation."
          </p>
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
        variant="danger"
        :loading="loading"
        @click="handleConfirm"
      >
        <span>Confirm Disconnect</span>
        <template #icon>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
        </template>
      </BaseButton>
    </template>
  </BaseModal>
</template>

<style scoped>
.text-danger {
  color: #ef4444;
}
.border-danger\/10 {
  border-color: rgba(239, 68, 68, 0.1);
}
.bg-danger\/5 {
  background-color: rgba(239, 68, 68, 0.05);
}
.decoration-danger\/40 {
  text-decoration-color: rgba(239, 68, 68, 0.4);
}
</style>
