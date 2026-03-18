<script setup>
const colors = {
  red: '#FF6058',
  yellow: '#FFBD2E',
  green: '#28C840'
}
</script>

<template>
  <div class="absolute right-10 top-1/4 w-80 bg-bg-surface border border-border-strong rounded-xl overflow-hidden z-20">
    <!-- Title bar -->
    <div class="bg-bg-elevated px-3.5 py-2.5 flex items-center gap-1.5 border-b border-border">
      <div class="flex gap-1.5">
        <div class="w-2 h-2 rounded-full" :style="{ backgroundColor: colors.red }" />
        <div class="w-2 h-2 rounded-full" :style="{ backgroundColor: colors.yellow }" />
        <div class="w-2 h-2 rounded-full" :style="{ backgroundColor: colors.green }" />
      </div>
      <span class="font-mono text-[10px] text-text-ghost ml-1.5 tracking-wider">smartedge • terminal</span>
    </div>
    
    <!-- Body -->
    <div class="p-3.5 font-mono text-[11px] leading-[1.9]">
      <div class="text-text-ghost">$ scan --sector tech --iv-rank &gt;70</div>
      <div class="text-cyan">TSLA 248C | IV: 92.4 | Score: 87 ↑</div>
      <div class="text-cyan">NVDA 880C | IV: 78.1 | Score: 79 ↑</div>
      <div class="text-cyan">AAPL 190C | IV: 65.8 | Score: 72 ↑</div>
      <div class="text-text-muted pl-4">3 contracts found · 2.4s</div>
      <div class="text-text-ghost mt-2">$ analyze TSLA 248C</div>
      <div class="text-text-muted pl-4">Signal: <span class="text-profit">BULLISH</span></div>
      <div class="text-text-muted pl-4">Probability: <span class="text-profit">78.5%</span></div>
      <div class="text-text-muted pl-4">Expires: Mar 21, 2026</div>
      <div class="text-warn mt-2">⚠ Market alert: VIX +4.2%</div>
      <div class="text-text-ghost">$<span class="animate-blink">_</span></div>
    </div>
  </div>
</template>

<style scoped>
.animate-blink {
  animation: blink 1s step-start infinite;
}
</style>
