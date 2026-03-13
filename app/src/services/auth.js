import api from '@/lib/api/axios'

export const getCsrfCookie = async () => {
    return await api.get('/sanctum/csrf-cookie')
}

export const login = credentials => {
    return api.post('/api/v1/login', credentials)
}

export const logout = () => {
    return api.post('/api/v1/logout')
}

export const getCurrentUser = () => {
    return api.get('/api/v1/user')
}
