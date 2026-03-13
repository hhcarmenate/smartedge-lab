<script setup>
import { ref } from 'vue'
import { getCsrfCookie, login } from '@/services/auth.js'
import { useAuthStore } from '@/stores/auth.js'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const loading = ref(false)

const authStore = useAuthStore()
const router = useRouter()

const handleLogin = async () => {
  try {
    loading.value = true
    await getCsrfCookie()

    const response = await login({
      email: email.value,
      password: password.value,
    })

    if (response.status === 200) {
      authStore.setUser(response.data?.user || null)
      await router.push({ name: 'dashboard' })
    }
  } catch (error) {
    console.error('Login error:', error)
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <main class="relative min-h-screen overflow-hidden bg-black text-text-primary">
    <!-- Ambient background -->
    <div class="pointer-events-none absolute inset-0">
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,138,0,0.18),transparent_22%)]"></div>
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(255,138,0,0.10),transparent_28%)]"></div>
      <div class="absolute inset-0 bg-[linear-gradient(to_bottom,rgba(255,255,255,0.015),transparent_20%,transparent_78%,rgba(255,138,0,0.06))]"></div>
    </div>

    <div class="relative mx-auto flex min-h-screen max-w-7xl items-center px-6 py-10">
      <div class="grid w-full items-center gap-14 xl:grid-cols-[1.02fr_0.98fr]">
        <!-- Left content -->
        <section class="max-w-2xl space-y-8">
          <div class="space-y-5">
            <p class="font-mono text-[11px] font-bold uppercase tracking-[0.45em] text-white/70">
              SMARTEDGE LAB
            </p>

            <h1 class="text-5xl font-black leading-[0.9] tracking-tight md:text-7xl">
              <span class="block text-white">Secure</span>
              <span class="block bg-gradient-to-r from-white via-[#ffd089] to-accent bg-clip-text text-transparent">
                terminal
              </span>
              <span class="block text-white">access for</span>
              <span class="block text-white">real execution</span>
            </h1>

            <p class="max-w-xl text-base leading-8 text-text-secondary md:text-lg">
              Access your trading workspace for watchlists, setups, paper trades, and review.
              <span class="text-accent"> Fast, focused, and built for clarity.</span>
            </p>
          </div>

          <div class="flex flex-wrap items-center gap-4 pt-2">
            <div
                class="inline-flex items-center gap-3 rounded-xl border border-accent/25 bg-[linear-gradient(180deg,rgba(255,138,0,0.10),rgba(255,138,0,0.03))] px-5 py-3 text-sm text-white shadow-[0_0_20px_rgba(255,138,0,0.10)]"
            >
              <div class="h-2.5 w-2.5 rounded-full bg-success shadow-[0_0_12px_rgba(16,185,129,0.8)]"></div>
              <span>Secure terminal access</span>
            </div>

            <router-link
                to="/"
                class="inline-flex items-center justify-center rounded-xl border border-white/12 bg-white/[0.03] px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition-all duration-300 hover:border-accent/30 hover:bg-accent/[0.05] hover:text-accent"
            >
              Return to Hub
            </router-link>
          </div>

          <!-- Orange block -->
          <div
              class="relative overflow-hidden rounded-[24px] border border-accent/30 bg-gradient-to-br from-accent via-[#ff9a1f] to-[#ff6a00] p-7 text-black shadow-[0_30px_80px_rgba(255,138,0,0.28)]"
          >
            <div class="absolute inset-y-0 right-0 w-48 bg-[radial-gradient(circle_at_center,rgba(255,255,255,0.22),transparent_60%)]"></div>

            <div class="relative z-10 grid gap-6 md:grid-cols-[1fr_auto] md:items-center">
              <div>
                <p class="font-mono text-[10px] font-black uppercase tracking-[0.3em] text-black/75">
                  SmartEdge Access
                </p>
                <h2 class="mt-3 text-3xl font-black leading-tight md:text-4xl">
                  HIGH-SPEED
                  <span class="block">AUTH FLOW</span>
                </h2>
              </div>

              <div class="flex justify-start md:justify-end">
                <div class="relative h-28 w-28 rounded-full border-8 border-black/80">
                  <div class="absolute inset-3 rounded-full border-[6px] border-black/50"></div>
                  <div class="absolute inset-[26px] flex items-center justify-center rounded-full bg-black text-lg font-black text-accent">
                    GO
                  </div>

                  <div class="absolute -left-8 top-1/2 h-px w-8 bg-black/60"></div>
                  <div class="absolute -right-8 top-1/2 h-px w-8 bg-black/60"></div>
                  <div class="absolute left-1/2 -top-8 h-8 w-px bg-black/60"></div>
                  <div class="absolute bottom-[-2rem] left-1/2 h-8 w-px bg-black/60"></div>

                  <span class="absolute -left-14 top-[46%] text-[11px] font-black text-black/75">AUTH</span>
                  <span class="absolute -right-14 top-[46%] text-[11px] font-black text-black/75">SYNC</span>
                  <span class="absolute left-[41%] -top-7 text-[11px] font-black text-black/75">KEY</span>
                  <span class="absolute left-[41%] -bottom-7 text-[11px] font-black text-black/75">RUN</span>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- Login panel -->
        <section class="flex justify-center xl:justify-end">
          <div
              class="relative w-full max-w-xl overflow-hidden rounded-[30px] border border-accent/24 bg-[linear-gradient(180deg,rgba(12,12,13,0.98),rgba(4,4,5,1))] p-6 shadow-[0_24px_90px_rgba(0,0,0,0.65)]"
          >
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-accent/70 to-transparent"></div>
            <div class="absolute -right-20 top-0 h-64 w-64 rounded-full bg-accent/20 blur-[120px]"></div>
            <div class="absolute bottom-0 left-0 h-48 w-48 rounded-full bg-[#ffb84d]/10 blur-[100px]"></div>

            <div class="relative z-10 space-y-6">
              <div class="flex items-start justify-between">
                <div>
                  <p class="font-mono text-[10px] font-bold uppercase tracking-[0.35em] text-white/65">
                    SmartEdge Terminal
                  </p>
                  <h2 class="mt-3 text-3xl font-black tracking-tight text-white">
                    Initialize
                    <span class="text-accent">session</span>
                  </h2>
                </div>

                <div class="rounded-xl border border-white/15 bg-white/[0.03] px-3 py-2 text-[10px] font-bold uppercase tracking-[0.22em] text-white">
                  Live
                </div>
              </div>

              <form @submit.prevent="handleLogin" class="space-y-5">
                <div class="space-y-2">
                  <label
                      for="email"
                      class="font-mono text-[10px] font-bold uppercase tracking-[0.28em] text-white/65"
                  >
                    Identity / Email
                  </label>

                  <input
                      id="email"
                      v-model="email"
                      type="email"
                      autofocus
                      required
                      placeholder="operator@smartedge.lab"
                      class="w-full rounded-2xl border border-white/12 bg-[linear-gradient(180deg,rgba(17,17,19,0.98),rgba(11,11,12,1))] px-5 py-4 text-white placeholder:text-white/25 outline-none transition-all duration-300 focus:border-accent/35 focus:bg-accent/[0.04] focus:shadow-[0_0_0_1px_rgba(255,138,0,0.15),0_0_24px_rgba(255,138,0,0.10)]"
                  />
                </div>

                <div class="space-y-2">
                  <label
                      for="password"
                      class="font-mono text-[10px] font-bold uppercase tracking-[0.28em] text-white/65"
                  >
                    Security Key
                  </label>

                  <input
                      id="password"
                      v-model="password"
                      type="password"
                      required
                      placeholder="••••••••"
                      class="w-full rounded-2xl border border-white/12 bg-[linear-gradient(180deg,rgba(17,17,19,0.98),rgba(11,11,12,1))] px-5 py-4 text-white placeholder:text-white/25 outline-none transition-all duration-300 focus:border-accent/35 focus:bg-accent/[0.04] focus:shadow-[0_0_0_1px_rgba(255,138,0,0.15),0_0_24px_rgba(255,138,0,0.10)]"
                  />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                  <div
                      class="rounded-2xl border border-white/12 bg-[linear-gradient(180deg,rgba(16,16,18,0.98),rgba(8,8,9,1))] px-5 py-4"
                  >
                    <p class="font-mono text-[10px] font-bold uppercase tracking-[0.24em] text-white/60">
                      Access
                    </p>
                    <p class="mt-3 text-2xl font-black text-white">Secure</p>
                  </div>

                  <div
                      class="rounded-2xl border border-accent/28 bg-[linear-gradient(180deg,rgba(255,138,0,0.20),rgba(255,138,0,0.06))] px-5 py-4 shadow-[0_0_22px_rgba(255,138,0,0.14)]"
                  >
                    <p class="font-mono text-[10px] font-bold uppercase tracking-[0.24em] text-[#ffd089]">
                      Session
                    </p>
                    <p class="mt-3 text-2xl font-black text-white">Ready</p>
                  </div>
                </div>

                <button
                    type="submit"
                    :disabled="loading"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-gradient-to-r from-accent to-[#ff6a00] px-6 py-4 text-sm font-bold uppercase tracking-[0.22em] text-black transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_28px_rgba(255,138,0,0.35)] disabled:cursor-not-allowed disabled:opacity-50"
                >
                  <span v-if="!loading">Initialize Session</span>

                  <span v-else class="flex items-center gap-3">
                    <svg class="h-4 w-4 animate-spin text-black" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                      <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                      <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Authenticating...
                  </span>
                </button>
              </form>
            </div>
          </div>
        </section>
      </div>
    </div>
  </main>
</template>
