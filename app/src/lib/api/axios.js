import axios from 'axios'
import router from '@/router/index.js'
import { useAuthStore } from '@/stores/auth.js'

const api = axios.create({
    baseURL: import.meta.env.VITE_API_URL,
    withCredentials: true,
    withXSRFToken: true,
    xsrfCookieName: 'XSRF-TOKEN',
    xsrfHeaderName: 'X-XSRF-TOKEN',
    headers: {
        Accept: 'application/json',
        'Content-Type': 'application/json'
    }
})

api.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            const authStore = useAuthStore()
            if (authStore.isAuthenticated) {
                authStore.clearAuth()
                router.push({ name: 'login' })
            }
        }

        if (error.response?.status === 419) {
            console.warn('CSRF token mismatch.')
        }

        return Promise.reject(error)
    }
)

export default api
