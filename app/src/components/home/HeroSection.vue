<script setup>
import AppButton from '../ui/AppButton.vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const stats = [
  { value: '24K+', label: 'Active Signals' },
  { value: '$2.4M', label: 'Avg Daily Volume' },
  { value: '98.7%', label: 'Uptime' }
]
</script>

<template>
  <div class="relative px-10 py-20 min-h-[460px] flex items-center overflow-hidden bg-bg-base">
    <!-- Grid background -->
    <div class="absolute inset-0 opacity-30" style="background-image: linear-gradient(0deg, transparent 24%, rgba(0, 212, 255, 0.05) 25%, rgba(0, 212, 255, 0.05) 26%, transparent 27%, transparent 74%, rgba(0, 212, 255, 0.05) 75%, rgba(0, 212, 255, 0.05) 76%, transparent 77%, transparent), linear-gradient(90deg, transparent 24%, rgba(0, 212, 255, 0.05) 25%, rgba(0, 212, 255, 0.05) 26%, transparent 27%, transparent 74%, rgba(0, 212, 255, 0.05) 75%, rgba(0, 212, 255, 0.05) 76%, transparent 77%, transparent); background-size: 50px 50px;" />
    
    <!-- Radial glow -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full" style="background: radial-gradient(ellipse, rgba(0, 212, 255, 0.07), transparent 70%)" />
    
    <!-- Content -->
    <div class="relative z-10 max-w-[55%] pr-12">
      <!-- Tag pill -->
      <div class="inline-flex items-center gap-1.5 bg-cyan/8 border border-cyan/20 text-cyan font-mono text-[11px] px-3 py-1 rounded-pill mb-6">
        <span class="w-1 h-1 bg-cyan rounded-full animate-pulse" />
        Powered by AI
      </div>
      
      <!-- Headline -->
      <h1 class="text-[42px] font-bold leading-[1.1] tracking-tight mb-4">
        <span class="text-cyan">Before</span> the market moves,
        <span class="text-violet">market</span> moves you
      </h1>
      
      <!-- Subtext -->
      <p class="text-text-muted text-[15px] leading-relaxed max-w-[480px] mb-8">
        Real-time options intelligence with AI-powered signals. Scan thousands of contracts, execute smarter trades.
      </p>
      
      <!-- CTA buttons -->
      <div class="flex gap-3 mb-10">
        <AppButton variant="primary" @click="router.push('/dashboard')">
          Get Started
        </AppButton>
        <AppButton variant="ghost">
          Learn More
        </AppButton>
      </div>
      
      <!-- Stats row -->
      <div class="flex gap-6 pt-8 border-t border-border">
        <div v-for="stat in stats" :key="stat.label">
          <div class="font-mono text-[20px] font-semibold text-cyan">{{ stat.value }}</div>
          <div class="text-[11px] text-text-ghost mt-0.5 tracking-wide">{{ stat.label }}</div>
        </div>
      </div>
    </div>
  </div>
</template>
