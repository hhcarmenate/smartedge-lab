import { ref } from 'vue'

export function useSignals() {
  const signals = ref([])
  
  return { signals }
}
