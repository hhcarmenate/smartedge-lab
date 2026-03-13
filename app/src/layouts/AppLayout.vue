<script setup>
import { useAuthStore } from '@/stores/auth'
import { logout } from '@/services/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

const handleLogout = async () => {
  try {
    await logout()
  } catch (error) {
    console.error('Logout error', error)
  } finally {
    authStore.clearAuth()
    await router.push({ name: 'login' })
  }
}
</script>

<template>
  <main class="min-h-screen bg-black text-text-primary selection:bg-accent/20">
    <div class="relative min-h-screen overflow-hidden">
      <!-- Ambient background -->
      <div class="pointer-events-none absolute inset-0">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,138,0,0.18),transparent_22%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(255,138,0,0.10),transparent_30%)]"></div>
        <div class="absolute inset-0 bg-[linear-gradient(to_bottom,rgba(255,255,255,0.015),transparent_20%,transparent_80%,rgba(255,138,0,0.05))]"></div>
      </div>

      <div class="relative mx-auto max-w-7xl px-6 py-8">
        <div class="space-y-8">
          <!-- Hero Header -->
          <header
              class="relative overflow-hidden rounded-[32px] border border-accent/22 bg-[linear-gradient(180deg,rgba(15,15,16,0.98),rgba(5,5,5,1))] px-8 py-8 shadow-[0_28px_100px_rgba(0,0,0,0.6)]"
          >
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/70 to-transparent"></div>
            <div class="absolute -right-20 top-0 h-72 w-72 rounded-full bg-accent/20 blur-[130px]"></div>
            <div class="absolute bottom-0 left-0 h-56 w-56 rounded-full bg-[#ffb84d]/10 blur-[120px]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(135deg,rgba(255,138,0,0.035),transparent_30%,transparent_70%,rgba(255,184,77,0.03))]"></div>

            <div class="relative z-10 flex flex-col gap-8 xl:flex-row xl:items-center xl:justify-between">
              <slot name="header">
                <div class="max-w-3xl">
                  <p class="font-mono text-[11px] font-bold uppercase tracking-[0.45em] text-white/70">
                    SMARTEDGE LAB
                  </p>

                  <h1 class="mt-4 text-4xl font-black tracking-tight md:text-6xl">
                    <span class="text-white">Trading</span>
                    <span class="ml-2 bg-gradient-to-r from-white via-[#ffd089] to-accent bg-clip-text text-transparent">
                      Workspace
                    </span>
                  </h1>

                  <p class="mt-4 max-w-2xl text-sm leading-relaxed text-text-secondary md:text-base">
                    Focused swing trading assistant for watchlists, setups, paper trades, and journal review.
                    <span class="text-accent"> Built for clarity, discipline, and execution.</span>
                  </p>
                </div>
              </slot>

              <slot name="header-actions">
                <div class="grid gap-4 sm:grid-cols-2">
                  <div
                      class="rounded-2xl border border-white/12 bg-[linear-gradient(180deg,rgba(16,16,18,0.98),rgba(8,8,9,1))] px-5 py-4 shadow-[inset_0_1px_0_rgba(255,255,255,0.03)]"
                  >
                    <p class="font-mono text-[10px] font-bold uppercase tracking-[0.28em] text-white/60">
                      Session
                    </p>
                    <p class="mt-3 text-3xl font-black text-white">Ready</p>
                  </div>

                  <div
                      class="rounded-2xl border border-accent/30 bg-[linear-gradient(180deg,rgba(255,138,0,0.22),rgba(255,138,0,0.06))] px-5 py-4 shadow-[0_0_26px_rgba(255,138,0,0.16)]"
                  >
                    <p class="font-mono text-[10px] font-bold uppercase tracking-[0.28em] text-[#ffd089]">
                      Watchlists
                    </p>
                    <p class="mt-3 text-3xl font-black text-white">3</p>
                  </div>
                </div>
              </slot>
            </div>
          </header>

          <div class="grid gap-8 xl:grid-cols-[310px_1fr]">
            <!-- Sidebar -->
            <aside>
              <div
                  class="relative flex min-h-[700px] flex-col overflow-hidden rounded-[32px] border border-accent/16 bg-[linear-gradient(180deg,rgba(16,16,18,0.98),rgba(7,7,8,1))] p-5 shadow-[0_24px_80px_rgba(0,0,0,0.58)]"
              >
                <div class="absolute inset-y-0 right-0 w-px bg-gradient-to-b from-transparent via-white/8 to-transparent"></div>
                <div class="absolute -left-16 top-24 h-44 w-44 rounded-full bg-accent/12 blur-[110px]"></div>
                <div class="absolute bottom-0 left-0 h-40 w-40 rounded-full bg-[#ffb84d]/8 blur-[100px]"></div>
                <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(255,255,255,0.01),transparent_20%,transparent_80%,rgba(255,138,0,0.02))]"></div>

                <div class="relative z-10 mb-6 px-3">
                  <p class="font-mono text-[10px] font-bold uppercase tracking-[0.42em] text-white/65">
                    Navigation
                  </p>
                </div>

                <nav class="relative z-10 flex-grow space-y-2.5">
                  <RouterLink
                      to="/app/dashboard"
                      class="group relative flex items-center gap-3 overflow-hidden rounded-2xl border px-4 py-3.5 text-sm font-semibold transition-all duration-200"
                      :class="
                      $route.name === 'dashboard'
                        ? 'border-accent/30 bg-[linear-gradient(180deg,rgba(255,138,0,0.20),rgba(255,138,0,0.06))] text-white shadow-[0_0_24px_rgba(255,138,0,0.14)]'
                        : 'border-transparent text-text-secondary hover:border-white/10 hover:bg-white/[0.03] hover:text-white'
                    "
                  >
                    <div
                        class="absolute inset-y-2 left-0 w-1 rounded-r-full"
                        :class="$route.name === 'dashboard' ? 'bg-accent shadow-glow' : 'bg-transparent'"
                    ></div>

                    <div
                        class="h-2 w-2 rounded-full transition-all"
                        :class="$route.name === 'dashboard' ? 'bg-accent shadow-glow' : 'bg-white/25 group-hover:bg-accent'"
                    ></div>

                    <span>Overview</span>
                  </RouterLink>

                  <RouterLink
                      :to="{ name: 'watchlists.index' }"
                      class="group relative flex items-center gap-3 overflow-hidden rounded-2xl border px-4 py-3.5 text-sm font-semibold transition-all duration-200"
                      :class="
                      $route.path.includes('watchlists')
                        ? 'border-accent/30 bg-[linear-gradient(180deg,rgba(255,138,0,0.20),rgba(255,138,0,0.06))] text-white shadow-[0_0_24px_rgba(255,138,0,0.14)]'
                        : 'border-transparent text-text-secondary hover:border-white/10 hover:bg-white/[0.03] hover:text-white'
                    "
                  >
                    <div
                        class="absolute inset-y-2 left-0 w-1 rounded-r-full"
                        :class="$route.path.includes('watchlists') ? 'bg-accent shadow-glow' : 'bg-transparent'"
                    ></div>

                    <div
                        class="h-2 w-2 rounded-full transition-all"
                        :class="$route.path.includes('watchlists') ? 'bg-accent shadow-glow' : 'bg-white/25 group-hover:bg-accent'"
                    ></div>

                    <span>Watchlists</span>
                  </RouterLink>

                  <div
                      class="group flex cursor-pointer items-center gap-3 rounded-2xl border border-transparent px-4 py-3.5 text-sm font-semibold text-text-secondary transition-all duration-200 hover:border-white/10 hover:bg-white/[0.03] hover:text-white"
                  >
                    <div class="h-2 w-2 rounded-full bg-white/25 transition-all group-hover:bg-accent"></div>
                    <span>Signals Feed</span>
                  </div>

                  <div
                      class="group flex cursor-pointer items-center gap-3 rounded-2xl border border-transparent px-4 py-3.5 text-sm font-semibold text-text-secondary transition-all duration-200 hover:border-white/10 hover:bg-white/[0.03] hover:text-white"
                  >
                    <div class="h-2 w-2 rounded-full bg-white/25 transition-all group-hover:bg-accent"></div>
                    <span>Paper Trades</span>
                  </div>

                  <div
                      class="group flex cursor-pointer items-center gap-3 rounded-2xl border border-transparent px-4 py-3.5 text-sm font-semibold text-text-secondary transition-all duration-200 hover:border-white/10 hover:bg-white/[0.03] hover:text-white"
                  >
                    <div class="h-2 w-2 rounded-full bg-white/25 transition-all group-hover:bg-accent"></div>
                    <span>Journal</span>
                  </div>

                  <div
                      class="group flex cursor-pointer items-center gap-3 rounded-2xl border border-transparent px-4 py-3.5 text-sm font-semibold text-text-secondary transition-all duration-200 hover:border-white/10 hover:bg-white/[0.03] hover:text-white"
                  >
                    <div class="h-2 w-2 rounded-full bg-white/25 transition-all group-hover:bg-accent"></div>
                    <span>Settings</span>
                  </div>
                </nav>

                <!-- Dominant orange footer block -->
                <div class="mt-8">
                  <div
                      class="relative overflow-hidden rounded-[24px] border border-accent/28 bg-gradient-to-br from-accent via-[#ff9a1f] to-[#ff6a00] p-5 text-black shadow-[0_24px_70px_rgba(255,138,0,0.24)]"
                  >
                    <div class="absolute inset-y-0 right-0 w-24 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.20),transparent_60%)]"></div>

                    <div class="relative z-10">
                      <p class="font-mono text-[10px] font-black uppercase tracking-[0.28em] text-black/75">
                        Terminal
                      </p>
                      <p class="mt-3 text-2xl font-black leading-tight">
                        READY FOR
                        <span class="block">EXECUTION</span>
                      </p>
                    </div>
                  </div>
                </div>

                <div class="mt-auto pt-6">
                  <div class="mb-5 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

                  <button
                      @click="handleLogout"
                      class="w-full rounded-2xl border border-white/12 bg-[linear-gradient(180deg,rgba(18,18,20,0.98),rgba(10,10,10,1))] px-4 py-3 text-[11px] font-bold uppercase tracking-[0.24em] text-white transition-all duration-300 hover:border-accent/30 hover:bg-gradient-to-r hover:from-accent hover:to-[#ff6a00] hover:text-black hover:shadow-[0_0_24px_rgba(255,138,0,0.18)]"
                  >
                    Logout
                  </button>
                </div>
              </div>
            </aside>

            <!-- Main content shell -->
            <section class="min-h-0">
              <div
                  class="relative min-h-full rounded-[32px] border border-white/8 bg-[linear-gradient(180deg,rgba(10,10,11,0.70),rgba(6,6,7,0.35))] p-0"
              >
                <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
                <div class="pointer-events-none absolute -right-8 top-10 h-40 w-40 rounded-full bg-accent/8 blur-[90px]"></div>

                <router-view />
              </div>
            </section>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
</style>
