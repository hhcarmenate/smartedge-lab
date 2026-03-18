<script setup>
import { useClock } from '@/composables/useClock'
import AppBadge from '../ui/AppBadge.vue'

const { time } = useClock()

const pageTitle = 'Dashboard'
</script>

<template>
  <div class="h-12 bg-bg-surface border-b border-border flex items-center justify-between px-4">
    <!-- Left -->
    <div class="flex items-center gap-3">
      <span class="text-sm font-semibold text-text-primary">{{ pageTitle }}</span>
      <div class="flex items-center gap-1.5 text-profit font-mono text-[11px]">
        <span class="w-1.5 h-1.5 bg-profit rounded-full animate-pulse" />
        Market Open
      </div>
    </div>
    
    <!-- Right -->
    <div class="flex items-center gap-2.5">
      <span class="font-mono text-[11px] text-text-ghost">{{ time }}</span>
      <AppBadge variant="green" label="LIVE" />
      <AppBadge variant="violet" label="PRO" />
      <div class="w-7 h-7 rounded-full bg-gradient-to-br from-violet to-cyan flex items-center justify-center text-[10px] font-bold text-bg-base">
        U
      </div>
    </div>
  </div>
</template>
