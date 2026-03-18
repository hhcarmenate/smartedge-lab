import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useSignalsStore = defineStore('signals', () => {
  const signals = ref([])
  
  return { signals }
})
