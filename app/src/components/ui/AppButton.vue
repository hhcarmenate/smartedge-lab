<script setup>
defineProps({
  variant: { type: String, default: 'primary' }, // primary, ghost
  type: { type: String, default: 'button' }
})

const variantClasses = {
  primary: 'bg-cyan text-bg-base font-bold hover:bg-cyan-dim transition-colors duration-150',
  ghost: 'border border-border-strong text-text-primary hover:bg-bg-hover transition-all duration-200'
}
</script>

<template>
  <button :type="type" :class="`px-4 py-2 rounded-chip font-sans text-sm ${variantClasses[variant]}`">
    <slot />
  </button>
</template>
