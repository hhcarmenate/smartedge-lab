import { createRouter, createWebHistory } from 'vue-router'
import HomeView from "../views/HomeView.vue";
import LoginView from "../views/LoginView.vue";
import DashboardView from "@/views/DashboardView.vue";
import AppLayout from "@/layouts/AppLayout.vue";
import {useAuthStore} from "@/stores/auth.js";

import watchlistsRoutes from "@/modules/watchlists/routes/index.js";

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeView
    },
    {
        path: '/login',
        name: 'login',
        component: LoginView
    },
    {
        path: '/app',
        component: AppLayout,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '',
                redirect: { name: 'dashboard' }
            },
            {
                path: 'dashboard',
                name: 'dashboard',
                component: DashboardView
            },
            ...watchlistsRoutes
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

router.beforeEach((to) => {
    const authStore = useAuthStore()

    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        return { name: 'login' }
    }

    if (to.name === 'login' && authStore.isAuthenticated) {
        return { name: 'dashboard' }
    }
})

export default router
