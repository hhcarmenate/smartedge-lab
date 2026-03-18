import { ref, onMounted, onUnmounted } from 'vue'

export function useClock() {
  const time = ref('')

  function update() {
    const n = new Date()
    const h = String(n.getHours()).padStart(2, '0')
    const m = String(n.getMinutes()).padStart(2, '0')
    const s = String(n.getSeconds()).padStart(2, '0')
    time.value = `${h}:${m}:${s} EST`
  }

  let interval
  onMounted(() => { update(); interval = setInterval(update, 1000) })
  onUnmounted(() => clearInterval(interval))

  return { time }
}
