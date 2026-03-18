<script setup>
defineProps({
  score: { type: Number, default: 0 } // 0-100
})

const getScoreColor = (score) => {
  if (score >= 75) return 'bg-profit'
  if (score >= 50) return 'bg-warn'
  return 'bg-loss'
}
</script>

<template>
  <div class="flex items-center gap-1.5">
    <div class="flex-1 h-1 bg-bg-hover rounded-full overflow-hidden">
      <div :class="`h-full rounded-full transition-all duration-200 ${getScoreColor(score)}`" :style="{ width: `${score}%` }" />
    </div>
    <div class="font-mono text-[10px] text-text-muted min-w-[22px] text-right">{{ score }}</div>
  </div>
</template>
