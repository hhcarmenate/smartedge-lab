<script setup>
defineProps({
  title: String
})
</script>

<template>
  <div class="bg-bg-surface border border-border rounded-card overflow-hidden">
    <div v-if="title" class="px-4 py-3 border-b border-border flex items-center justify-between">
      <div class="text-sm font-semibold tracking-wide">
        <slot name="header">{{ title }}</slot>
      </div>
      <div class="flex gap-1.5 items-center">
        <slot name="actions" />
      </div>
    </div>
    <div>
      <slot />
    </div>
  </div>
</template>
