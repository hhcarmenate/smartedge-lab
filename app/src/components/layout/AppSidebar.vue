<script setup>
import { useRoute, useRouter } from 'vue-router'
import { BarChart2, Search, Zap, Briefcase, TrendingUp, Settings, User, BookOpen, LogOut, List } from 'lucide-vue-next'
import { logout } from '@/services/auth.js'
import { useAuthStore } from '@/stores/auth.js'
import { useSidebar } from '@/composables/useSidebar.js'

const route = useRoute()
const router = useRouter()
const authStore = useAuthStore()
const { collapsed } = useSidebar()

const handleLogout = async () => {
  try {
    await logout()
  } finally {
    authStore.clearAuth()
    router.push({ name: 'login' })
  }
}

const navItems = [
  { path: '/dashboard',  icon: BarChart2,  label: 'Dashboard' },
  { path: '/watchlists', icon: List,       label: 'Watchlists' },
  { path: '/scanner',    icon: Search,     label: 'Scanner' },
  { path: '/signals',    icon: Zap,        label: 'Signals' },
  { path: '/portfolio',  icon: Briefcase,  label: 'Portfolio' },
  { path: '/charts',     icon: TrendingUp, label: 'Charts' },
  { path: '/journal',    icon: BookOpen,   label: 'Journal' },
  { path: '/settings',   icon: Settings,   label: 'Settings' },
]

const isActive = (path) => route.path === path || (path !== '/' && route.path.startsWith(path))
</script>

<template>
  <div
    :class="[
      'bg-bg-surface border-r border-border flex flex-col py-4 gap-2 transition-all duration-200',
      collapsed ? 'w-[52px] items-center' : 'w-[180px] items-stretch px-2'
    ]"
  >
    <!-- Logo -->
    <div :class="['flex items-center gap-2 mb-2', collapsed ? 'justify-center' : 'px-1']">
      <div class="w-8 h-8 shrink-0 bg-cyan/10 border border-cyan/20 rounded-chip flex items-center justify-center text-[10px] font-bold font-mono text-cyan">
        S
      </div>
      <span v-if="!collapsed" class="text-xs font-bold font-mono text-cyan tracking-widest uppercase flex-1">SmartEdge</span>
    </div>

    <!-- Nav items -->
    <div :class="['flex flex-col gap-1', collapsed ? 'items-center' : '']">
      <router-link
        v-for="item in navItems"
        :key="item.path"
        :to="item.path"
        :title="collapsed ? item.label : undefined"
        :class="[
          'flex items-center gap-3 rounded-chip transition-all duration-150 relative',
          collapsed ? 'w-9 h-9 justify-center' : 'h-9 px-3',
          isActive(item.path)
            ? 'bg-bg-hover text-cyan'
            : 'text-text-ghost hover:bg-bg-hover hover:text-cyan'
        ]"
      >
        <span v-if="isActive(item.path) && collapsed" class="absolute left-0 top-2 w-0.5 h-5 bg-cyan rounded-full" />
        <span v-if="isActive(item.path) && !collapsed" class="absolute left-0 top-2 w-0.5 h-5 bg-cyan rounded-full" />
        <component :is="item.icon" class="h-4 w-4 shrink-0" />
        <span v-if="!collapsed" class="text-xs font-medium">{{ item.label }}</span>
      </router-link>
    </div>

    <!-- Spacer -->
    <div class="flex-1" />

    <!-- Bottom -->
    <div :class="['flex flex-col gap-1', collapsed ? 'items-center' : '']">
      <button
        :class="[
          'flex items-center gap-3 rounded-chip text-text-ghost hover:bg-bg-hover hover:text-cyan transition-all duration-150',
          collapsed ? 'w-9 h-9 justify-center' : 'h-9 px-3 w-full'
        ]"
        :title="collapsed ? 'Profile' : undefined"
      >
        <User class="h-4 w-4 shrink-0" />
        <span v-if="!collapsed" class="text-xs font-medium">Profile</span>
      </button>

      <button
        @click="handleLogout"
        :class="[
          'flex items-center gap-3 rounded-chip text-text-ghost hover:bg-bg-hover hover:text-loss transition-all duration-150',
          collapsed ? 'w-9 h-9 justify-center' : 'h-9 px-3 w-full'
        ]"
        :title="collapsed ? 'Log out' : undefined"
      >
        <LogOut class="h-4 w-4 shrink-0" />
        <span v-if="!collapsed" class="text-xs font-medium">Log out</span>
      </button>

    </div>
  </div>
</template>
