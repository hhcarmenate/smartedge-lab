<script setup>
import { Zap, Bot, BarChart2, Briefcase, Bell, TrendingUp } from 'lucide-vue-next'

const features = [
  {
    icon: Zap,
    title: 'Real-Time Scanning',
    desc: 'Monitor thousands of options contracts with sub-second latency',
    color: 'cyan'
  },
  {
    icon: Bot,
    title: 'AI-Powered Signals',
    desc: 'Machine learning models trained on 10+ years of market data',
    color: 'violet'
  },
  {
    icon: BarChart2,
    title: 'Advanced Analytics',
    desc: 'IV rank, probability analysis, and greeks at your fingertips',
    color: 'cyan'
  },
  {
    icon: Briefcase,
    title: 'Portfolio Tracking',
    desc: 'Monitor all positions with real-time P&L and risk metrics',
    color: 'profit'
  },
  {
    icon: Bell,
    title: 'Smart Alerts',
    desc: 'Customizable notifications for signals and market events',
    color: 'warn'
  },
  {
    icon: TrendingUp,
    title: 'Trade Journal',
    desc: 'Track performance and optimize your trading strategy over time',
    color: 'cyan'
  }
]

const colorMap = {
  cyan: { bg: 'bg-cyan/10', border: 'border-cyan/20', text: 'text-cyan' },
  violet: { bg: 'bg-violet/10', border: 'border-violet/20', text: 'text-violet' },
  profit: { bg: 'bg-profit/10', border: 'border-profit/20', text: 'text-profit' },
  warn: { bg: 'bg-warn/10', border: 'border-warn/20', text: 'text-warn' }
}
</script>

<template>
  <div class="px-10 py-20 bg-bg-base">
    <div class="grid grid-cols-3 gap-4">
      <div v-for="feature in features" :key="feature.title" class="bg-bg-surface border border-border rounded-xl p-5 transition-all duration-250 hover:border-border-strong hover:bg-bg-elevated hover:-translate-y-0.5">
        <div :class="`w-9 h-9 rounded-chip flex items-center justify-center mb-3.5 ${colorMap[feature.color].bg} ${colorMap[feature.color].border} border ${colorMap[feature.color].text}`">
          <component :is="feature.icon" class="h-4 w-4" />
        </div>
        <div class="text-[13px] font-semibold mb-1.5">{{ feature.title }}</div>
        <div class="text-text-muted text-[12px] leading-relaxed">{{ feature.desc }}</div>
      </div>
    </div>
  </div>
</template>
