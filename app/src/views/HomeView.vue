<script setup>
import HeroSection from '../components/home/HeroSection.vue'
import TickerTape from '../components/home/TickerTape.vue'
import TerminalPreview from '../components/home/TerminalPreview.vue'
import FeatureGrid from '../components/home/FeatureGrid.vue'
import CtaSection from '../components/home/CtaSection.vue'
</script>

<template>
  <div class="bg-bg-base">
    <TickerTape />
    <div class="relative">
      <HeroSection />
      <TerminalPreview />
    </div>
    <FeatureGrid />
    <CtaSection />
  </div>
</template>
