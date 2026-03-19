<script setup>
import { ref } from 'vue'
import { getCsrfCookie, login } from '@/services/auth.js'
import { useAuthStore } from '@/stores/auth.js'
import { useRouter } from 'vue-router'
import { ArrowRight } from 'lucide-vue-next'

const email = ref('')
const password = ref('')
const loading = ref(false)
const errorMessage = ref('')

const authStore = useAuthStore()
const router = useRouter()

const handleLogin = async () => {
  errorMessage.value = ''
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
    const status = error?.response?.status
    if (status === 401 || status === 422) {
      errorMessage.value = 'Invalid credentials. Please check your email and password.'
    } else if (status >= 500) {
      errorMessage.value = 'Server error. Please try again later.'
    } else {
      errorMessage.value = 'Unable to connect. Check your network and try again.'
    }
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <main class="relative min-h-screen overflow-hidden bg-bg-base text-text-primary">
    <!-- Ambient background -->
    <div class="pointer-events-none absolute inset-0">
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(0,212,255,0.12),transparent_25%)]"></div>
      <div class="absolute inset-0 bg-[radial-gradient(circle_at_bottom_left,rgba(123,92,245,0.08),transparent_30%)]"></div>
      <div class="absolute inset-0 bg-[linear-gradient(to_bottom,rgba(255,255,255,0.02),transparent_20%,transparent_80%,rgba(0,212,255,0.04))]"></div>
    </div>

    <div class="relative mx-auto flex min-h-screen max-w-7xl items-center px-6 py-10">
      <div class="grid w-full items-center gap-14 xl:grid-cols-[1.02fr_0.98fr]">
        <!-- Left content -->
        <section class="max-w-2xl space-y-8">
          <div class="space-y-5">
            <p class="font-mono text-[11px] font-bold uppercase tracking-[0.45em] text-text-muted">
              SMARTEDGE LAB
            </p>

            <h1 class="text-5xl font-black leading-[0.9] tracking-tight md:text-7xl">
              <span class="block text-text-primary">Access your</span>
              <span class="block bg-gradient-to-r from-cyan via-violet to-cyan bg-clip-text text-transparent">
                trading terminal
              </span>
              <span class="block text-text-primary">right now</span>
            </h1>

            <p class="max-w-xl text-base leading-8 text-text-muted md:text-lg">
              Access your trading workspace for watchlists, setups, paper trades, and review.
              <span class="text-cyan"> Fast, focused, and built for clarity.</span>
            </p>
          </div>

          <div class="flex flex-wrap items-center gap-4 pt-2">
            <div class="inline-flex items-center gap-3 rounded-chip border border-cyan/25 bg-cyan/8 px-5 py-3 text-sm text-text-primary">
              <div class="h-2.5 w-2.5 rounded-full bg-profit animate-pulse"></div>
              <span>Secure terminal access</span>
            </div>

            <router-link
                to="/"
                class="inline-flex items-center justify-center rounded-chip border border-border-strong text-text-primary px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] transition-all duration-300 hover:border-cyan/50 hover:bg-cyan/10 hover:text-cyan"
            >
              Return to Hub
            </router-link>
          </div>

          <!-- Feature highlight block -->
          <div class="relative overflow-hidden rounded-card border border-border-strong bg-bg-elevated p-6">
            <div class="absolute inset-y-0 right-0 w-32 bg-[radial-gradient(circle_at_center,rgba(0,212,255,0.1),transparent_70%)]"></div>

            <div class="relative z-10 grid gap-4 md:grid-cols-[1fr_auto] md:items-center">
              <div>
                <p class="font-mono text-[10px] font-bold uppercase tracking-[0.3em] text-text-ghost">
                  SmartEdge Access
                </p>
                <h2 class="mt-3 text-2xl font-bold leading-tight text-text-primary">
                  Instant<span class="text-cyan"> Trading Access</span>
                </h2>
              </div>

              <div class="rounded-full border-4 border-border-strong bg-bg-base h-20 w-20 flex items-center justify-center">
                <ArrowRight class="h-6 w-6 text-cyan" />
              </div>
            </div>
          </div>
        </section>

        <!-- Login panel -->
        <section class="flex justify-center xl:justify-end">
          <div class="relative w-full max-w-md overflow-hidden rounded-card border border-border-strong bg-bg-surface p-8">
            <div class="absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-cyan/50 to-transparent"></div>
            <div class="absolute -right-20 top-0 h-64 w-64 rounded-full bg-cyan/20 blur-[120px]"></div>
            <div class="absolute bottom-0 left-0 h-48 w-48 rounded-full bg-violet/10 blur-[100px]"></div>

            <div class="relative z-10 space-y-6">
              <div class="flex items-start justify-between">
                <div>
                  <p class="font-mono text-[10px] font-bold uppercase tracking-[0.35em] text-text-muted">
                    SmartEdge Terminal
                  </p>
                  <h2 class="mt-3 text-2xl font-bold tracking-tight text-text-primary">
                    Initialize <span class="text-cyan">session</span>
                  </h2>
                </div>

                <div class="rounded-chip border border-border-strong bg-bg-base px-3 py-2 text-[10px] font-bold uppercase tracking-[0.22em] text-text-primary">
                  Live
                </div>
              </div>

              <form @submit.prevent="handleLogin" class="space-y-5">
                <div class="space-y-2">
                  <label for="email" class="font-mono text-[10px] font-bold uppercase tracking-[0.28em] text-text-muted">
                    Identity / Email
                  </label>

                  <input
                      id="email"
                      v-model="email"
                      type="email"
                      autofocus
                      required
                      placeholder="operator@smartedge.lab"
                      class="w-full rounded-chip border border-border bg-bg-base px-4 py-3 text-text-primary placeholder:text-text-ghost outline-none transition-all duration-300 focus:border-cyan/50 focus:bg-cyan/5 focus:ring-1 focus:ring-cyan/30"
                  />
                </div>

                <div class="space-y-2">
                  <label for="password" class="font-mono text-[10px] font-bold uppercase tracking-[0.28em] text-text-muted">
                    Security Key
                  </label>

                  <input
                      id="password"
                      v-model="password"
                      type="password"
                      required
                      placeholder="••••••••"
                      class="w-full rounded-chip border border-border bg-bg-base px-4 py-3 text-text-primary placeholder:text-text-ghost outline-none transition-all duration-300 focus:border-cyan/50 focus:bg-cyan/5 focus:ring-1 focus:ring-cyan/30"
                  />
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                  <div class="rounded-chip border border-border bg-bg-base px-4 py-3">
                    <p class="font-mono text-[10px] font-bold uppercase tracking-[0.24em] text-text-muted">
                      Access
                    </p>
                    <p class="mt-2 text-lg font-bold text-text-primary">Secure</p>
                  </div>

                  <div class="rounded-chip border border-cyan/30 bg-cyan/10 px-4 py-3">
                    <p class="font-mono text-[10px] font-bold uppercase tracking-[0.24em] text-cyan">
                      Session
                    </p>
                    <p class="mt-2 text-lg font-bold text-text-primary">Ready</p>
                  </div>
                </div>

                <div
                    v-if="errorMessage"
                    class="rounded-chip border border-loss/40 bg-loss/10 px-4 py-3 text-sm text-loss"
                >
                  {{ errorMessage }}
                </div>

                <button
                    type="submit"
                    :disabled="loading"
                    class="inline-flex w-full items-center justify-center rounded-chip bg-cyan text-bg-base px-6 py-3 text-sm font-bold uppercase tracking-[0.22em] transition-all duration-300 hover:bg-cyan-dim hover:shadow-[0_0_24px_rgba(0,212,255,0.4)] disabled:cursor-not-allowed disabled:opacity-50"
                >
                  <span v-if="!loading">Initialize Session</span>

                  <span v-else class="flex items-center gap-3">
                    <svg class="h-4 w-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
