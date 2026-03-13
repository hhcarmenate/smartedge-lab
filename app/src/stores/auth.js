import {defineStore} from "pinia";
import {computed, ref} from "vue";

const AUTH_STORAGE_KEY = 'smartedge.auth.user'

const getStoredUser = () => {
    const storedUser = localStorage.getItem(AUTH_STORAGE_KEY)
    return storedUser ? JSON.parse(storedUser) : null
}

export const useAuthStore = defineStore('auth', () => {
    const user = ref(getStoredUser())

    const isAuthenticated = computed(() => !!user.value)

    const setUser = (userData) => {
        user.value = userData
        localStorage.setItem(AUTH_STORAGE_KEY, JSON.stringify(userData))
    }

    const clearAuth = () => {
        user.value = null
        localStorage.removeItem(AUTH_STORAGE_KEY)
    }

    return {
        user,
        isAuthenticated,
        setUser,
        clearAuth
    }
})
