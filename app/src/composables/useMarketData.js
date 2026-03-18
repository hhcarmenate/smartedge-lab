import { ref } from 'vue'

export function useMarketData() {
  const marketData = ref({})
  
  return { marketData }
}
