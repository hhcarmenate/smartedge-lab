<script setup>
import { computed } from 'vue'

const props = defineProps({
  variant: {
    type: String,
    default: 'primary', // primary (accent), danger, ghost, outline
    validator: (value) => ['primary', 'danger', 'ghost', 'outline'].includes(value)
  },
  size: {
    type: String,
    default: 'md',
    validator: (value) => ['sm', 'md', 'lg'].includes(value)
  },
  loading: {
    type: Boolean,
    default: false
  },
  disabled: {
    type: Boolean,
    default: false
  },
  type: {
    type: String,
    default: 'button'
  },
  fullWidth: {
    type: Boolean,
    default: false
  }
})

const variants = {
  primary: 'bg-gradient-to-r from-accent to-[#ff6a00] text-black hover:brightness-110 hover:shadow-[0_0_30px_rgba(255,138,0,0.35)]',
  danger: 'bg-gradient-to-r from-danger/80 to-[#ff0000] text-white hover:brightness-110 hover:shadow-[0_0_25px_rgba(239,68,68,0.3)]',
  ghost: 'text-white/40 hover:text-white bg-transparent',
  outline: 'border border-white/10 bg-white/[0.03] text-white/70 hover:border-white/20 hover:bg-white/[0.06] hover:text-white'
}

const sizes = {
  sm: 'px-4 py-2 text-[9px]',
  md: 'px-6 py-3.5 text-[11px]',
  lg: 'px-10 py-4 text-[11px]'
}

const classes = computed(() => [
  'cursor-pointer group relative flex items-center justify-center gap-3 overflow-hidden rounded-xl font-black uppercase tracking-[0.2em] transition-all duration-300 active:scale-[0.98] disabled:cursor-not-allowed disabled:opacity-40 disabled:active:scale-100',
  variants[props.variant],
  sizes[props.size],
  props.fullWidth ? 'w-full' : ''
])
</script>

<template>
  <button
    :type="type"
    :class="classes"
    :disabled="disabled || loading"
  >
    <!-- Loading State -->
    <div v-if="loading" class="flex items-center gap-2">
      <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
      </svg>
      <span v-if="$slots.loading">
        <slot name="loading"></slot>
      </span>
      <span v-else>Processing...</span>
    </div>

    <!-- Default State -->
    <template v-else>
      <slot></slot>
      <slot name="icon"></slot>
    </template>
  </button>
</template>

<style scoped>
.text-danger {
  color: #ef4444;
}
</style>
