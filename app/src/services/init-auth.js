import {useAuthStore} from "@/stores/auth.js";
import { getCurrentUser } from "@/services/auth.js";

export const initializeAuth = async () => {
    const authStore = useAuthStore();

    try {
        const response = await getCurrentUser();
        authStore.setUser(response.data?.user || null)
    } catch (error) {
        authStore.clearAuth()
    }
}
