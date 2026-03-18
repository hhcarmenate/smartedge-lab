<script setup>
import AppButton from '../ui/AppButton.vue'
import { useRouter } from 'vue-router'

const router = useRouter()
</script>

<template>
  <div class="px-10 py-20 bg-bg-base text-center">
    <h2 class="text-[32px] font-bold mb-3">Ready to trade smarter?</h2>
    <p class="text-text-muted text-[15px] mb-8 max-w-[500px] mx-auto">Join thousands of traders using SmartEdge Lab to find better options trades.</p>
    <AppButton variant="primary" @click="router.push('/dashboard')">
      Start Free Trial
    </AppButton>
  </div>
</template>
