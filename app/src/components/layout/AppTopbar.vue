<script setup>
import { useClock } from '@/composables/useClock'
import { useSidebar } from '@/composables/useSidebar.js'
import { PanelLeftOpen, PanelLeftClose } from 'lucide-vue-next'
import AppBadge from '../ui/AppBadge.vue'

const { time } = useClock()
const { collapsed, toggle } = useSidebar()

const pageTitle = 'Dashboard'
</script>

<template>
  <div class="h-12 bg-bg-surface border-b border-border flex items-center justify-between px-4">
    <!-- Left -->
    <div class="flex items-center gap-3">
      <button
        @click="toggle"
        class="h-7 w-7 flex items-center justify-center rounded-chip text-text-ghost hover:bg-bg-hover hover:text-cyan transition-all duration-150"
        :title="collapsed ? 'Expand sidebar' : 'Collapse sidebar'"
      >
        <PanelLeftOpen v-if="collapsed" class="h-4 w-4" />
        <PanelLeftClose v-else class="h-4 w-4" />
      </button>
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
