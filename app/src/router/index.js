import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  { path: '/',          component: () => import('../views/HomeView.vue') },
  { path: '/dashboard', component: () => import('../views/DashboardView.vue') },
  { path: '/scanner',   component: () => import('../views/ScannerView.vue') },
  { path: '/signals',   component: () => import('../views/SignalsView.vue') },
  { path: '/portfolio', component: () => import('../views/PortfolioView.vue') },
  { path: '/charts',    component: () => import('../views/ChartsView.vue') },
  { path: '/settings',  component: () => import('../views/SettingsView.vue') },
]

export default createRouter({
  history: createWebHistory(),
  routes
})
