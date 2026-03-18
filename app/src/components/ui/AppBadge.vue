<script setup>
defineProps({
  variant: { type: String, default: 'cyan' }, // cyan, green, amber, red, violet
  label: { type: String, required: true }
})

const variantClasses = {
  cyan:   'bg-cyan/10 text-cyan border border-cyan/20',
  green:  'bg-profit/10 text-profit border border-profit/20',
  amber:  'bg-warn/10 text-warn border border-warn/20',
  red:    'bg-loss/10 text-loss border border-loss/20',
  violet: 'bg-violet/10 text-violet border border-violet/20'
}
</script>

<template>
  <span :class="`font-mono text-[10px] font-semibold px-1.5 py-0.5 rounded ${variantClasses[variant]}`">
    {{ label }}
  </span>
</template>
