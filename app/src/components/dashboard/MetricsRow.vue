<script setup>
import MetricCard from '../ui/MetricCard.vue'

const metrics = [
  { label: 'Active Signals', value: '24', change: '+3', changeType: 'up', accent: 'cyan' },
  { label: 'Portfolio P&L', value: '+$2.4K', change: '+6.3%', changeType: 'up', accent: 'profit' },
  { label: 'IV Rank (SPY)', value: '72.4', change: '↑ 8.2', changeType: 'up', accent: 'violet' },
  { label: 'Contracts Scanned', value: '18,432', change: '+2,100', changeType: 'up', accent: 'warn' }
]
</script>

<template>
  <div class="grid grid-cols-4 gap-2.5">
    <MetricCard v-for="metric in metrics" :key="metric.label" v-bind="metric" />
  </div>
</template>
