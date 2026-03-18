import { defineStore } from 'pinia'
import { ref } from 'vue'

export const useScannerStore = defineStore('scanner', () => {
  const scanResults = ref([])
  
  return { scanResults }
})
