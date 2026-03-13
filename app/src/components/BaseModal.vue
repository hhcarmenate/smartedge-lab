<script setup>
import { onMounted, onUnmounted, ref, watch } from 'vue'

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  title: {
    type: String,
    default: ''
  },
  maxWidth: {
    type: String,
    default: 'max-w-xl'
  },
  closeOnEsc: {
    type: Boolean,
    default: true
  },
  closeOnBackdrop: {
    type: Boolean,
    default: true
  }
})

const emit = defineEmits(['close'])

const close = () => {
  emit('close')
}

const handleEsc = (e) => {
  if (props.show && props.closeOnEsc && e.key === 'Escape') {
    close()
  }
}

const handleBackdrop = () => {
  if (props.closeOnBackdrop) {
    close()
  }
}

watch(() => props.show, (newVal) => {
  if (newVal) {
    document.body.style.overflow = 'hidden'
  } else {
    document.body.style.overflow = ''
  }
})

onMounted(() => {
  window.addEventListener('keydown', handleEsc)
})

onUnmounted(() => {
  window.removeEventListener('keydown', handleEsc)
  document.body.style.overflow = ''
})
</script>

<template>
  <Teleport to="body">
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">
        <!-- Backdrop -->
        <div
          class="fixed inset-0 bg-background/80 backdrop-blur-sm transition-opacity"
          @click="handleBackdrop"
        ></div>

        <!-- Modal Container -->
        <Transition
          enter-active-class="transition duration-300 ease-out"
          enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="transition duration-200 ease-in"
          leave-from-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <div
            v-if="show"
            class="relative w-full transform overflow-hidden rounded-[28px] border border-white/10 bg-[linear-gradient(180deg,rgba(14,14,15,0.98),rgba(6,6,7,1))] p-1 shadow-[0_25px_70px_rgba(0,0,0,0.6)] transition-all"
            :class="maxWidth"
          >
            <!-- Decorative gradient border top -->
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/50 to-transparent"></div>

            <div class="relative bg-surface-elevated/50 p-6 sm:p-8 rounded-[24px]">
              <!-- Header -->
              <div class="mb-6 flex items-center justify-between">
                <div>
                  <div v-if="title" class="mb-1 flex items-center gap-2">
                    <div class="h-2 w-0.5 bg-accent"></div>
                    <p class="font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-accent/80">
                      System // Terminal
                    </p>
                  </div>
                  <h3 v-if="title" class="text-xl font-black tracking-tight text-white sm:text-2xl">
                    {{ title }}
                  </h3>
                  <slot name="header-content"></slot>
                </div>

                <button
                  @click="close"
                  class="group flex h-10 w-10 items-center justify-center rounded-xl border border-white/5 bg-white/[0.03] text-text-secondary transition-all hover:border-accent/30 hover:bg-accent/10 hover:text-accent hover:shadow-[0_0_15px_rgba(255,138,0,0.1)]"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                </button>
              </div>

              <!-- Body -->
              <div class="relative">
                <slot></slot>
              </div>

              <!-- Footer -->
              <div v-if="$slots.footer" class="mt-8 flex flex-col-reverse gap-3 border-t border-white/5 pt-6 sm:flex-row sm:justify-end">
                <slot name="footer"></slot>
              </div>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<style scoped>
.shadow-glow {
  box-shadow: 0 0 20px rgba(255, 138, 0, 0.2);
}
</style>
