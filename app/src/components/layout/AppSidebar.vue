<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()

const navItems = [
  { path: '/dashboard', icon: '📊', label: 'Dashboard' },
  { path: '/scanner', icon: '🔍', label: 'Scanner' },
  { path: '/signals', icon: '⚡', label: 'Signals' },
  { path: '/portfolio', icon: '💼', label: 'Portfolio' },
  { path: '/charts', icon: '📈', label: 'Charts' },
  { path: '/settings', icon: '⚙️', label: 'Settings' }
]

const isActive = (path) => route.path === path
</script>

<template>
  <div class="w-[52px] bg-bg-surface border-r border-border flex flex-col items-center py-4 gap-2">
    <!-- Logo -->
    <div class="w-8 h-8 bg-cyan/10 border border-cyan/20 rounded-chip flex items-center justify-center text-[10px] font-bold font-mono text-cyan">
      S
    </div>
    
    <!-- Nav items -->
    <div class="flex flex-col gap-2">
      <router-link 
        v-for="item in navItems" 
        :key="item.path" 
        :to="item.path"
        :class="[
          'w-9 h-9 rounded-chip flex items-center justify-center text-lg transition-all duration-150',
          isActive(item.path)
            ? 'bg-bg-hover text-cyan relative'
            : 'text-text-ghost hover:bg-bg-hover hover:text-cyan'
        ]"
        :title="item.label"
      >
        <span v-if="isActive(item.path)" class="absolute left-0 top-2 w-0.5 h-5 bg-cyan rounded-full" />
        {{ item.icon }}
      </router-link>
    </div>
    
    <!-- Spacer -->
    <div class="flex-1" />
    
    <!-- Bottom icons -->
    <div class="flex flex-col gap-2">
      <button class="w-9 h-9 rounded-chip flex items-center justify-center text-lg text-text-ghost hover:bg-bg-hover hover:text-cyan transition-all duration-150">
        👤
      </button>
    </div>
  </div>
</template>
