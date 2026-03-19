import { createRouter, createWebHistory } from 'vue-router'
import watchlistRoutes from '@/modules/watchlists/routes/index.js'

const routes = [
  { path: '/',      name: 'home',  component: () => import('../views/HomeView.vue') },
  { path: '/login', name: 'login', component: () => import('../views/LoginView.vue') },
  {
    path: '/',
    component: () => import('../components/layout/AppShell.vue'),
    children: [
      { path: 'dashboard', name: 'dashboard', component: () => import('../views/DashboardView.vue') },
      { path: 'scanner',   name: 'scanner',   component: () => import('../views/ScannerView.vue') },
      { path: 'signals',   name: 'signals',   component: () => import('../views/SignalsView.vue') },
      { path: 'portfolio', name: 'portfolio', component: () => import('../views/PortfolioView.vue') },
      { path: 'charts',    name: 'charts',    component: () => import('../views/ChartsView.vue') },
      { path: 'journal',   name: 'journal',   component: () => import('../views/JournalView.vue') },
      { path: 'settings',  name: 'settings',  component: () => import('../views/SettingsView.vue') },
      ...watchlistRoutes,
    ],
  },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
