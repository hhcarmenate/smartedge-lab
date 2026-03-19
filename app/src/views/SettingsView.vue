<script setup>
import { ref } from 'vue'
import AppBadge from '../components/ui/AppBadge.vue'
import {
  User, Palette, Bell, ScanLine, Activity,
  Layers, Plug, Code2, ChevronRight, Check,
  Eye, EyeOff, Copy, RefreshCw, Plus, Trash2,
  ToggleLeft, ToggleRight, Zap
} from 'lucide-vue-next'

// ── Active section ─────────────────────────────────────────────
const activeSection = ref('profile')

const sections = [
  { id: 'profile',     label: 'Profile & Account',  icon: User },
  { id: 'appearance',  label: 'Appearance',          icon: Palette },
  { id: 'notifications', label: 'Notifications',     icon: Bell },
  { id: 'scanner',     label: 'Scanner Defaults',    icon: ScanLine },
  { id: 'indicators',  label: 'Indicators',          icon: Activity },
  { id: 'setups',      label: 'Features & Setups',   icon: Layers },
  { id: 'integrations', label: 'Integrations',       icon: Plug },
  { id: 'api',         label: 'API & Developer',     icon: Code2 },
]

// ── Profile ────────────────────────────────────────────────────
const profile = ref({
  name: 'Alex Morgan',
  email: 'alex@smartedge.lab',
  timezone: 'America/New_York',
  timeFormat: '24h',
})
const showPassword = ref(false)

// ── Appearance ─────────────────────────────────────────────────
const theme       = ref('cyber-dark')
const density     = ref('comfortable')
const numberFormat = ref('en-US')

const themes = [
  { id: 'cyber-dark',  label: 'Cyber Dark',  preview: ['#04070F', '#00D4FF', '#7B5CF5'] },
  { id: 'midnight',    label: 'Midnight',    preview: ['#0A0A12', '#818CF8', '#34D399'] },
  { id: 'terminal',    label: 'Terminal',    preview: ['#0D1117', '#3FB950', '#58A6FF'] },
]

// ── Notifications ──────────────────────────────────────────────
const notifications = ref({
  inApp:      true,
  email:      false,
  webhook:    false,
  minScore:   75,
  quietStart: '22:00',
  quietEnd:   '08:00',
  maxPerHour: 10,
})

// ── Scanner defaults ───────────────────────────────────────────
const scannerDefaults = ref({
  defaultWatchlist: 'all',
  defaultDirection: 'all',
  minScore:         70,
  autoRun:          false,
  runInterval:      15,
})

// ── Indicators (mock) ──────────────────────────────────────────
const indicators = ref([
  { id: 1, name: 'IV Rank',       category: 'Volatility', params: { period: 252, threshold: 70 }, active: true },
  { id: 2, name: 'IV Percentile', category: 'Volatility', params: { period: 252, threshold: 60 }, active: true },
  { id: 3, name: 'RSI',           category: 'Momentum',   params: { period: 14,  overbought: 70, oversold: 30 }, active: true },
  { id: 4, name: 'Volume Surge',  category: 'Volume',     params: { multiplier: 2.0, lookback: 20 }, active: true },
  { id: 5, name: 'OI Delta',      category: 'Options',    params: { threshold: 15 }, active: false },
  { id: 6, name: 'VWAP Distance', category: 'Price',      params: { threshold: 2.5 }, active: false },
])

const categoryColor = {
  Volatility: 'red',
  Momentum:   'cyan',
  Volume:     'violet',
  Options:    'amber',
  Price:      'green',
}

// ── Features & Setups (mock) ───────────────────────────────────
const setups = ref([
  {
    id: 1, name: 'IV Crush Play', direction: 'neutral', active: true,
    features: [
      { name: 'IV Spike',    indicators: ['IV Rank', 'IV Percentile'] },
      { name: 'Volume Surge', indicators: ['Volume Surge'] },
    ],
  },
  {
    id: 2, name: 'Momentum Breakout', direction: 'bull', active: true,
    features: [
      { name: 'RSI Cross',    indicators: ['RSI'] },
      { name: 'Volume Surge', indicators: ['Volume Surge'] },
      { name: 'Price Action', indicators: ['VWAP Distance'] },
    ],
  },
  {
    id: 3, name: 'Mean Reversion', direction: 'bear', active: true,
    features: [
      { name: 'Overbought RSI',   indicators: ['RSI'] },
      { name: 'IV Percentile',    indicators: ['IV Percentile'] },
    ],
  },
  {
    id: 4, name: 'Earnings Play', direction: 'neutral', active: false,
    features: [
      { name: 'Earnings Proximity', indicators: ['IV Rank'] },
      { name: 'IV Expansion',       indicators: ['IV Rank', 'OI Delta'] },
    ],
  },
])

const directionBadge = { bull: 'green', bear: 'red', neutral: 'amber' }

// ── Integrations ───────────────────────────────────────────────
const integrations = ref([
  { id: 'tradingview', name: 'TradingView',  status: 'connected',    icon: '📈', desc: 'Chart sync and webhook alerts' },
  { id: 'tda',         name: 'TD Ameritrade', status: 'disconnected', icon: '🏦', desc: 'Paper trading and order routing' },
  { id: 'slack',       name: 'Slack',        status: 'disconnected', icon: '💬', desc: 'Signal notifications to channels' },
  { id: 'webhook',     name: 'Webhook',      status: 'disconnected', icon: '🔗', desc: 'Custom POST endpoint on signals' },
])

// ── API ────────────────────────────────────────────────────────
const apiKey     = ref('se_live_k9xT2mP4nQrVbWsYzA8cDfGhJuLo3Ei')
const showApiKey = ref(false)
const apiCopied  = ref(false)

const copyApiKey = () => {
  navigator.clipboard.writeText(apiKey.value)
  apiCopied.value = true
  setTimeout(() => { apiCopied.value = false }, 2000)
}

const maskedKey = (key) => key.slice(0, 8) + '•'.repeat(20) + key.slice(-4)

// ── Helpers ────────────────────────────────────────────────────
const saved = ref(false)
const save = () => {
  saved.value = true
  setTimeout(() => { saved.value = false }, 2000)
}
</script>

<template>
  <div class="flex bg-bg-base min-h-screen">

        <!-- ── Left nav ─────────────────────────────────────────── -->
        <aside class="w-56 shrink-0 border-r border-border bg-bg-surface p-3 space-y-0.5">
          <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost px-3 pt-2 pb-3">Settings</p>

          <button
            v-for="s in sections"
            :key="s.id"
            @click="activeSection = s.id"
            :class="[
              'w-full flex items-center gap-3 px-3 py-2.5 rounded-chip transition-all duration-150 text-left group',
              activeSection === s.id
                ? 'bg-bg-hover text-cyan'
                : 'text-text-muted hover:bg-bg-elevated hover:text-text-primary'
            ]"
          >
            <component :is="s.icon" class="h-4 w-4 shrink-0" />
            <span class="text-[13px] font-medium">{{ s.label }}</span>
            <ChevronRight v-if="activeSection === s.id" class="h-3 w-3 ml-auto text-cyan" />
          </button>
        </aside>

        <!-- ── Content ──────────────────────────────────────────── -->
        <main class="flex-1 p-8 overflow-auto">
          <div class="max-w-2xl space-y-8">

            <!-- ── PROFILE ───────────────────────────────────────── -->
            <template v-if="activeSection === 'profile'">
              <div>
                <h2 class="text-lg font-bold text-text-primary">Profile & Account</h2>
                <p class="text-sm text-text-muted mt-1">Manage your identity and access credentials.</p>
              </div>

              <!-- Avatar row -->
              <div class="bg-bg-surface border border-border rounded-card p-6 flex items-center gap-6">
                <div class="h-16 w-16 rounded-full bg-gradient-to-br from-violet to-cyan flex items-center justify-center text-xl font-bold text-bg-base shrink-0">
                  AM
                </div>
                <div>
                  <p class="font-semibold text-text-primary">{{ profile.name }}</p>
                  <p class="text-sm text-text-muted mt-0.5">{{ profile.email }}</p>
                  <div class="flex gap-2 mt-2">
                    <AppBadge variant="cyan" label="PRO" />
                    <AppBadge variant="green" label="ACTIVE" />
                  </div>
                </div>
              </div>

              <!-- Fields -->
              <div class="bg-bg-surface border border-border rounded-card divide-y divide-border">
                <div class="p-5 space-y-1.5">
                  <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Display Name</label>
                  <input v-model="profile.name" class="w-full bg-bg-elevated border border-border rounded-chip px-3 py-2 text-sm text-text-primary outline-none focus:border-cyan/40 transition-colors" />
                </div>
                <div class="p-5 space-y-1.5">
                  <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Email Address</label>
                  <input v-model="profile.email" type="email" class="w-full bg-bg-elevated border border-border rounded-chip px-3 py-2 text-sm text-text-primary outline-none focus:border-cyan/40 transition-colors" />
                </div>
                <div class="p-5 space-y-1.5">
                  <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Password</label>
                  <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" value="••••••••••••" class="w-full bg-bg-elevated border border-border rounded-chip px-3 py-2 pr-10 text-sm text-text-primary outline-none focus:border-cyan/40 transition-colors" />
                    <button @click="showPassword = !showPassword" class="absolute right-3 top-1/2 -translate-y-1/2 text-text-ghost hover:text-text-primary transition-colors">
                      <component :is="showPassword ? EyeOff : Eye" class="h-4 w-4" />
                    </button>
                  </div>
                </div>
                <div class="p-5 grid grid-cols-2 gap-4">
                  <div class="space-y-1.5">
                    <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Timezone</label>
                    <select v-model="profile.timezone" class="w-full appearance-none bg-bg-elevated border border-border rounded-chip px-3 py-2 text-sm text-text-primary outline-none focus:border-cyan/40 transition-colors">
                      <option value="America/New_York">Eastern (ET)</option>
                      <option value="America/Chicago">Central (CT)</option>
                      <option value="America/Los_Angeles">Pacific (PT)</option>
                      <option value="Europe/London">London (GMT)</option>
                    </select>
                  </div>
                  <div class="space-y-1.5">
                    <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Time Format</label>
                    <select v-model="profile.timeFormat" class="w-full appearance-none bg-bg-elevated border border-border rounded-chip px-3 py-2 text-sm text-text-primary outline-none focus:border-cyan/40 transition-colors">
                      <option value="12h">12h (AM/PM)</option>
                      <option value="24h">24h</option>
                    </select>
                  </div>
                </div>
              </div>
            </template>

            <!-- ── APPEARANCE ─────────────────────────────────────── -->
            <template v-else-if="activeSection === 'appearance'">
              <div>
                <h2 class="text-lg font-bold text-text-primary">Appearance</h2>
                <p class="text-sm text-text-muted mt-1">Customize how the terminal looks and feels.</p>
              </div>

              <!-- Theme picker -->
              <div class="bg-bg-surface border border-border rounded-card p-5 space-y-4">
                <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Theme</p>
                <div class="grid grid-cols-3 gap-3">
                  <button
                    v-for="t in themes"
                    :key="t.id"
                    @click="theme = t.id"
                    :class="[
                      'relative rounded-card border p-4 text-left transition-all duration-150',
                      theme === t.id
                        ? 'border-cyan/50 bg-cyan/5'
                        : 'border-border hover:border-border-strong'
                    ]"
                  >
                    <div class="flex gap-1.5 mb-3">
                      <span v-for="c in t.preview" :key="c" class="h-4 w-4 rounded-full" :style="{ backgroundColor: c }" />
                    </div>
                    <p class="text-sm font-semibold text-text-primary">{{ t.label }}</p>
                    <Check v-if="theme === t.id" class="h-3.5 w-3.5 text-cyan absolute top-3 right-3" />
                  </button>
                </div>
              </div>

              <!-- Layout density -->
              <div class="bg-bg-surface border border-border rounded-card p-5 space-y-4">
                <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Layout Density</p>
                <div class="flex gap-2">
                  <button
                    v-for="d in ['compact', 'comfortable', 'spacious']"
                    :key="d"
                    @click="density = d"
                    :class="[
                      'px-4 py-2 rounded-chip text-sm font-medium capitalize transition-all duration-150',
                      density === d
                        ? 'bg-cyan/15 text-cyan border border-cyan/30'
                        : 'border border-border text-text-muted hover:border-border-strong hover:text-text-primary'
                    ]"
                  >
                    {{ d }}
                  </button>
                </div>
              </div>

              <!-- Number format -->
              <div class="bg-bg-surface border border-border rounded-card p-5 space-y-4">
                <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Number Format</p>
                <div class="flex gap-2">
                  <button
                    v-for="f in [{ id: 'en-US', label: '1,234.56' }, { id: 'de-DE', label: '1.234,56' }]"
                    :key="f.id"
                    @click="numberFormat = f.id"
                    :class="[
                      'px-4 py-2 rounded-chip font-mono text-sm transition-all duration-150',
                      numberFormat === f.id
                        ? 'bg-cyan/15 text-cyan border border-cyan/30'
                        : 'border border-border text-text-muted hover:border-border-strong hover:text-text-primary'
                    ]"
                  >
                    {{ f.label }}
                  </button>
                </div>
              </div>
            </template>

            <!-- ── NOTIFICATIONS ──────────────────────────────────── -->
            <template v-else-if="activeSection === 'notifications'">
              <div>
                <h2 class="text-lg font-bold text-text-primary">Notifications</h2>
                <p class="text-sm text-text-muted mt-1">Control when and how you receive signal alerts.</p>
              </div>

              <!-- Channels -->
              <div class="bg-bg-surface border border-border rounded-card divide-y divide-border">
                <div v-for="channel in [
                  { key: 'inApp', label: 'In-App Alerts', desc: 'Show alerts inside the terminal' },
                  { key: 'email', label: 'Email', desc: 'Send signal digests to your inbox' },
                  { key: 'webhook', label: 'Webhook', desc: 'POST to a custom endpoint on each signal' },
                ]" :key="channel.key" class="flex items-center justify-between p-5">
                  <div>
                    <p class="text-sm font-medium text-text-primary">{{ channel.label }}</p>
                    <p class="text-xs text-text-muted mt-0.5">{{ channel.desc }}</p>
                  </div>
                  <button @click="notifications[channel.key] = !notifications[channel.key]">
                    <component
                      :is="notifications[channel.key] ? ToggleRight : ToggleLeft"
                      :class="['h-6 w-6 transition-colors', notifications[channel.key] ? 'text-cyan' : 'text-text-ghost']"
                    />
                  </button>
                </div>
              </div>

              <!-- Thresholds -->
              <div class="bg-bg-surface border border-border rounded-card divide-y divide-border">
                <div class="p-5 space-y-1.5">
                  <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Minimum Score to Alert</label>
                  <div class="flex items-center gap-4">
                    <input type="range" v-model="notifications.minScore" min="0" max="100" step="5" class="flex-1 accent-cyan" />
                    <span class="font-mono text-sm text-cyan w-8 text-right">{{ notifications.minScore }}</span>
                  </div>
                </div>
                <div class="p-5 grid grid-cols-2 gap-4">
                  <div class="space-y-1.5">
                    <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Quiet Hours Start</label>
                    <input type="time" v-model="notifications.quietStart" class="w-full bg-bg-elevated border border-border rounded-chip px-3 py-2 text-sm text-text-primary outline-none focus:border-cyan/40 transition-colors" />
                  </div>
                  <div class="space-y-1.5">
                    <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Quiet Hours End</label>
                    <input type="time" v-model="notifications.quietEnd" class="w-full bg-bg-elevated border border-border rounded-chip px-3 py-2 text-sm text-text-primary outline-none focus:border-cyan/40 transition-colors" />
                  </div>
                </div>
                <div class="p-5 space-y-1.5">
                  <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Max Alerts per Hour</label>
                  <input type="number" v-model="notifications.maxPerHour" min="1" max="60" class="w-32 bg-bg-elevated border border-border rounded-chip px-3 py-2 text-sm text-text-primary outline-none focus:border-cyan/40 transition-colors" />
                </div>
              </div>
            </template>

            <!-- ── SCANNER DEFAULTS ────────────────────────────────── -->
            <template v-else-if="activeSection === 'scanner'">
              <div>
                <h2 class="text-lg font-bold text-text-primary">Scanner Defaults</h2>
                <p class="text-sm text-text-muted mt-1">Pre-configure the scanner filters for every session.</p>
              </div>

              <div class="bg-bg-surface border border-border rounded-card divide-y divide-border">
                <div class="p-5 space-y-1.5">
                  <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Default Watchlist</label>
                  <select v-model="scannerDefaults.defaultWatchlist" class="w-full appearance-none bg-bg-elevated border border-border rounded-chip px-3 py-2 text-sm text-text-primary outline-none focus:border-cyan/40 transition-colors">
                    <option value="all">All Watchlists</option>
                    <option value="1">Tech Plays</option>
                    <option value="2">Earnings Watch</option>
                    <option value="3">High IV Targets</option>
                  </select>
                </div>
                <div class="p-5 space-y-1.5">
                  <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Default Direction</label>
                  <div class="flex gap-2">
                    <button
                      v-for="d in ['all', 'bull', 'bear', 'neutral']"
                      :key="d"
                      @click="scannerDefaults.defaultDirection = d"
                      :class="[
                        'px-4 py-2 rounded-chip font-mono text-[11px] capitalize transition-all duration-150',
                        scannerDefaults.defaultDirection === d
                          ? 'bg-cyan/15 text-cyan border border-cyan/30'
                          : 'border border-border text-text-muted hover:border-border-strong'
                      ]"
                    >
                      {{ d }}
                    </button>
                  </div>
                </div>
                <div class="p-5 space-y-1.5">
                  <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Minimum Score</label>
                  <div class="flex items-center gap-4">
                    <input type="range" v-model="scannerDefaults.minScore" min="0" max="100" step="5" class="flex-1 accent-cyan" />
                    <span class="font-mono text-sm text-cyan w-8 text-right">{{ scannerDefaults.minScore }}</span>
                  </div>
                </div>
                <div class="flex items-center justify-between p-5">
                  <div>
                    <p class="text-sm font-medium text-text-primary">Auto-run on load</p>
                    <p class="text-xs text-text-muted mt-0.5">Run the scanner automatically when you open the view</p>
                  </div>
                  <button @click="scannerDefaults.autoRun = !scannerDefaults.autoRun">
                    <component :is="scannerDefaults.autoRun ? ToggleRight : ToggleLeft" :class="['h-6 w-6 transition-colors', scannerDefaults.autoRun ? 'text-cyan' : 'text-text-ghost']" />
                  </button>
                </div>
                <div v-if="scannerDefaults.autoRun" class="p-5 space-y-1.5">
                  <label class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Auto-run interval (minutes)</label>
                  <input type="number" v-model="scannerDefaults.runInterval" min="1" max="60" class="w-32 bg-bg-elevated border border-border rounded-chip px-3 py-2 text-sm text-text-primary outline-none focus:border-cyan/40 transition-colors" />
                </div>
              </div>
            </template>

            <!-- ── INDICATORS ──────────────────────────────────────── -->
            <template v-else-if="activeSection === 'indicators'">
              <div class="flex items-start justify-between">
                <div>
                  <h2 class="text-lg font-bold text-text-primary">Indicators</h2>
                  <p class="text-sm text-text-muted mt-1">Configure the building blocks of your features and setups.</p>
                </div>
                <AppBadge variant="violet" label="CONCEPTUAL" />
              </div>

              <div class="space-y-2">
                <div
                  v-for="ind in indicators"
                  :key="ind.id"
                  :class="[
                    'bg-bg-surface border rounded-card p-4 transition-all duration-150',
                    ind.active ? 'border-border' : 'border-border opacity-50'
                  ]"
                >
                  <div class="flex items-start justify-between gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                      <div class="h-8 w-8 rounded-chip bg-bg-elevated border border-border flex items-center justify-center shrink-0">
                        <Activity class="h-3.5 w-3.5 text-text-ghost" />
                      </div>
                      <div class="min-w-0">
                        <div class="flex items-center gap-2">
                          <p class="text-sm font-semibold text-text-primary">{{ ind.name }}</p>
                          <AppBadge :variant="categoryColor[ind.category]" :label="ind.category" />
                        </div>
                        <div class="flex flex-wrap gap-2 mt-2">
                          <span
                            v-for="(val, key) in ind.params"
                            :key="key"
                            class="font-mono text-[10px] text-text-ghost border border-border rounded px-2 py-0.5"
                          >
                            {{ key }}: <span class="text-text-muted">{{ val }}</span>
                          </span>
                        </div>
                      </div>
                    </div>
                    <button @click="ind.active = !ind.active" class="shrink-0">
                      <component :is="ind.active ? ToggleRight : ToggleLeft" :class="['h-6 w-6 transition-colors', ind.active ? 'text-cyan' : 'text-text-ghost']" />
                    </button>
                  </div>
                </div>
              </div>

              <div class="border border-dashed border-border rounded-card p-4 flex items-center justify-center gap-2 text-text-ghost hover:border-border-strong hover:text-text-muted transition-colors cursor-not-allowed">
                <Plus class="h-4 w-4" />
                <span class="text-sm">Add Indicator</span>
                <AppBadge variant="violet" label="SOON" />
              </div>
            </template>

            <!-- ── FEATURES & SETUPS ───────────────────────────────── -->
            <template v-else-if="activeSection === 'setups'">
              <div class="flex items-start justify-between">
                <div>
                  <h2 class="text-lg font-bold text-text-primary">Features & Setups</h2>
                  <p class="text-sm text-text-muted mt-1">
                    Indicators form <span class="text-cyan">features</span>. Features form <span class="text-violet">setups</span>.
                  </p>
                </div>
                <AppBadge variant="violet" label="CONCEPTUAL" />
              </div>

              <div class="space-y-3">
                <div
                  v-for="setup in setups"
                  :key="setup.id"
                  :class="[
                    'bg-bg-surface border rounded-card transition-all duration-150',
                    setup.active ? 'border-border' : 'border-border opacity-50'
                  ]"
                >
                  <!-- Setup header -->
                  <div class="flex items-center justify-between px-5 py-4 border-b border-border">
                    <div class="flex items-center gap-3">
                      <Zap class="h-4 w-4 text-text-ghost" />
                      <p class="text-sm font-semibold text-text-primary">{{ setup.name }}</p>
                      <AppBadge :variant="directionBadge[setup.direction]" :label="setup.direction.toUpperCase()" />
                    </div>
                    <div class="flex items-center gap-3">
                      <button @click="setup.active = !setup.active">
                        <component :is="setup.active ? ToggleRight : ToggleLeft" :class="['h-6 w-6 transition-colors', setup.active ? 'text-cyan' : 'text-text-ghost']" />
                      </button>
                    </div>
                  </div>

                  <!-- Features pipeline -->
                  <div class="p-4 space-y-2">
                    <p class="font-mono text-[9px] uppercase tracking-widest text-text-ghost mb-3">Features</p>
                    <div class="flex flex-wrap gap-2">
                      <div
                        v-for="(feature, fi) in setup.features"
                        :key="fi"
                        class="bg-bg-elevated border border-border rounded-chip px-3 py-2 space-y-1.5"
                      >
                        <p class="font-mono text-[11px] font-semibold text-text-primary">{{ feature.name }}</p>
                        <div class="flex flex-wrap gap-1">
                          <span
                            v-for="ind in feature.indicators"
                            :key="ind"
                            class="font-mono text-[9px] bg-cyan/10 text-cyan border border-cyan/20 rounded px-1.5 py-0.5"
                          >
                            {{ ind }}
                          </span>
                        </div>
                      </div>
                      <div class="border border-dashed border-border rounded-chip px-3 py-2 flex items-center gap-1.5 text-text-ghost cursor-not-allowed">
                        <Plus class="h-3 w-3" />
                        <span class="font-mono text-[10px]">Feature</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="border border-dashed border-border rounded-card p-4 flex items-center justify-center gap-2 text-text-ghost hover:border-border-strong hover:text-text-muted transition-colors cursor-not-allowed">
                <Plus class="h-4 w-4" />
                <span class="text-sm">Add Setup</span>
                <AppBadge variant="violet" label="SOON" />
              </div>
            </template>

            <!-- ── INTEGRATIONS ────────────────────────────────────── -->
            <template v-else-if="activeSection === 'integrations'">
              <div>
                <h2 class="text-lg font-bold text-text-primary">Integrations</h2>
                <p class="text-sm text-text-muted mt-1">Connect external tools and data sources.</p>
              </div>

              <div class="space-y-3">
                <div
                  v-for="integration in integrations"
                  :key="integration.id"
                  class="bg-bg-surface border border-border rounded-card p-5 flex items-center gap-4"
                >
                  <div class="h-10 w-10 rounded-chip bg-bg-elevated border border-border flex items-center justify-center text-lg shrink-0">
                    <Plug class="h-4 w-4 text-text-ghost" />
                  </div>
                  <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                      <p class="text-sm font-semibold text-text-primary">{{ integration.name }}</p>
                      <AppBadge
                        :variant="integration.status === 'connected' ? 'green' : 'amber'"
                        :label="integration.status.toUpperCase()"
                      />
                    </div>
                    <p class="text-xs text-text-muted mt-0.5">{{ integration.desc }}</p>
                  </div>
                  <button
                    :class="[
                      'px-4 py-2 rounded-chip text-[11px] font-mono font-bold uppercase tracking-wider transition-all duration-150',
                      integration.status === 'connected'
                        ? 'border border-loss/30 text-loss hover:bg-loss/10'
                        : 'border border-border text-text-muted hover:border-border-strong hover:text-text-primary cursor-not-allowed'
                    ]"
                  >
                    {{ integration.status === 'connected' ? 'Disconnect' : 'Connect' }}
                  </button>
                </div>
              </div>
            </template>

            <!-- ── API & DEVELOPER ─────────────────────────────────── -->
            <template v-else-if="activeSection === 'api'">
              <div>
                <h2 class="text-lg font-bold text-text-primary">API & Developer</h2>
                <p class="text-sm text-text-muted mt-1">Access SmartEdge Lab programmatically.</p>
              </div>

              <!-- API Key -->
              <div class="bg-bg-surface border border-border rounded-card p-5 space-y-4">
                <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">API Key</p>
                <div class="flex gap-2">
                  <div class="flex-1 bg-bg-elevated border border-border rounded-chip px-3 py-2 font-mono text-[11px] text-text-muted overflow-hidden text-ellipsis whitespace-nowrap">
                    {{ showApiKey ? apiKey : maskedKey(apiKey) }}
                  </div>
                  <button @click="showApiKey = !showApiKey" class="p-2 rounded-chip border border-border text-text-ghost hover:text-text-primary hover:border-border-strong transition-all">
                    <component :is="showApiKey ? EyeOff : Eye" class="h-4 w-4" />
                  </button>
                  <button @click="copyApiKey" :class="['flex items-center gap-1.5 px-3 py-2 rounded-chip border text-[11px] font-mono transition-all duration-150', apiCopied ? 'border-profit/30 text-profit bg-profit/10' : 'border-border text-text-muted hover:border-border-strong hover:text-text-primary']">
                    <component :is="apiCopied ? Check : Copy" class="h-3.5 w-3.5" />
                    {{ apiCopied ? 'Copied' : 'Copy' }}
                  </button>
                  <button class="flex items-center gap-1.5 px-3 py-2 rounded-chip border border-border text-text-muted text-[11px] font-mono hover:border-border-strong hover:text-text-primary transition-all">
                    <RefreshCw class="h-3.5 w-3.5" />
                    Rotate
                  </button>
                </div>
                <p class="text-[11px] text-text-ghost">Keep your API key secret. Rotating it will invalidate the current one immediately.</p>
              </div>

              <!-- Endpoints reference -->
              <div class="bg-bg-surface border border-border rounded-card divide-y divide-border">
                <div class="px-5 py-3 flex items-center gap-2">
                  <p class="font-mono text-[10px] uppercase tracking-widest text-text-ghost">Endpoint Reference</p>
                  <AppBadge variant="violet" label="SOON" />
                </div>
                <div v-for="ep in [
                  { method: 'GET',  path: '/api/v1/scanner/run',      desc: 'Trigger a scan and return results' },
                  { method: 'GET',  path: '/api/v1/watchlists',       desc: 'List all watchlists with symbols' },
                  { method: 'GET',  path: '/api/v1/signals',          desc: 'Fetch latest matched signals' },
                  { method: 'POST', path: '/api/v1/setups/:id/run',   desc: 'Run a specific setup against a watchlist' },
                ]" :key="ep.path" class="flex items-center gap-4 px-5 py-3.5">
                  <AppBadge :variant="ep.method === 'GET' ? 'cyan' : 'violet'" :label="ep.method" />
                  <span class="font-mono text-[11px] text-text-primary flex-1">{{ ep.path }}</span>
                  <span class="text-[11px] text-text-ghost">{{ ep.desc }}</span>
                </div>
              </div>
            </template>

            <!-- ── Save button ──────────────────────────────────────── -->
            <div class="flex justify-end pt-2">
              <button
                @click="save"
                :class="[
                  'flex items-center gap-2 px-6 py-2.5 rounded-chip font-mono text-[11px] font-bold uppercase tracking-[0.15em] transition-all duration-200',
                  saved
                    ? 'bg-profit/20 text-profit border border-profit/30'
                    : 'bg-cyan text-bg-base hover:bg-cyan-dim'
                ]"
              >
                <Check v-if="saved" class="h-3.5 w-3.5" />
                {{ saved ? 'Saved' : 'Save Changes' }}
              </button>
            </div>

          </div>
        </main>
      </div>
</template>
