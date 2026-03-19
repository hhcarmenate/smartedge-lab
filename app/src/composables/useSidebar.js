import { ref } from 'vue'

const collapsed = ref(false)

export const useSidebar = () => ({
  collapsed,
  toggle: () => { collapsed.value = !collapsed.value },
})
