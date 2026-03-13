<script setup>
import BaseModal from '@/components/BaseModal.vue'
import BaseButton from '@/components/BaseButton.vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  watchlist: {
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
  if (!props.watchlist?.id) return
  emit('confirm', props.watchlist.id)
}
</script>

<template>
  <BaseModal
    :show="show"
    title="Terminate Watchlist"
    max-width="max-w-md"
    @close="handleClose"
  >
    <div class="space-y-6">
      <div class="flex items-center gap-4 rounded-2xl border border-danger/10 bg-danger/5 p-4">
        <div class="flex h-12 w-12 items-center justify-center rounded-xl border border-danger/20 bg-black text-xl shadow-inner">🗑️</div>
        <div class="space-y-1">
          <h4 class="font-mono text-[10px] font-bold uppercase tracking-[0.2em] text-danger/60">Danger Zone: Terminal Deletion</h4>
          <p class="text-xs font-medium text-text-secondary leading-relaxed">
            You are about to permanently delete the watchlist <span class="font-black text-white underline decoration-danger/40">{{ watchlist?.name }}</span>.
          </p>
        </div>
      </div>

      <div class="rounded-xl border border-dashed border-white/10 p-5 bg-white/[0.01]">
        <div class="space-y-4">
          <div class="flex items-center justify-between">
            <span class="font-mono text-[9px] font-bold uppercase tracking-widest text-white/20">Action Result</span>
            <span class="font-mono text-xs font-black text-danger">IRREVERSIBLE</span>
          </div>
          <div class="h-px bg-gradient-to-r from-transparent via-white/5 to-transparent"></div>
          <p class="text-[11px] font-medium leading-relaxed text-white/40 italic">
            "All symbol tracking and data associations for this terminal will be purged from the system database."
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
        <span>Confirm Deletion</span>
        <template #icon>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M10 11v6M14 11v6"/>
          </svg>
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
