<script setup>
import AppSidebar from './AppSidebar.vue'
import AppTopbar from './AppTopbar.vue'
</script>

<template>
  <div class="flex h-screen bg-bg-base">
    <AppSidebar />
    <div class="flex flex-col flex-1">
      <AppTopbar />
      <div class="flex-1 overflow-auto">
        <slot name="content" />
      </div>
    </div>
  </div>
</template>
